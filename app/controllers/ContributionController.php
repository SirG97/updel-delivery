<?php

namespace App\Controllers;

use App\Classes\Encryption;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Classes\CSRFToken;
use App\Classes\Random;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\Validation;
use App\Models\Order;
use App\Models\Pin;
use App\Models\Contribution;


class ContributionController extends BaseController {

    public $table_name = 'contributions';
    public $customers;
    public $links;

    public function __construct()
    {
        if(!isAuthenticated()){
            Redirect::to('/login');
        }
    }

    public function get_all(){
        $total = Contribution::all()->count();
        $object = new Contribution();

        list($contributions, $links) = paginate(20, $total, $this->table_name, $object);
        return view('user/contributions', ['contributions' => $contributions, 'links' => $links]);
    }

    public function contribute_form(){
        return view('user/contribute');
    }

    public function contribute(){
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                //Validation Rules
                $rules = [
                    'phone' => ['required' => true,'maxLength' => 14, 'minLength' => 11],
                    'pin' => ['required' => true,'minLength' => '12', 'maxLength' => '12', 'number' => true],
                ];

                //Run Validation and return errors
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    $errors = $validation->getErrorMessages();
                    return view('user/contribute', ['errors' => $errors]);
                }

                $is_registered_customer = Order::where('phone', '=', $request->phone)->first();
                if($is_registered_customer == null){
                    Session::add('error', 'This number is not registered');
                    return view('user/contribute');
                }

                //Check if user has been logged for fraud in the last 30 mins
                $fraud_status = ContributionController::is_fraudulent($request->phone);

                // Prevent the user from accessing the service for a brief period of time
                if($fraud_status == true){
                    Session::add('error', 'This number has been banned from using this service');
                    return view('user/contribute');
                }
                $encryption = new Encryption();
//              // Encrypt pin and check for match in databasr
                $is_pin_valid = Pin::find($encryption->encrypt($request->pin));
                if($is_pin_valid == NULL){
                    //Update Fraud table
                    $fraud_count = ContributionController::update_fraud_count($request->phone);
                    if($fraud_count === true){
                        Session::add('error', 'You have been barred from using this service');
                        return view('user/contribute');
                    }else{
                        $error_msg = 'You have only '. $fraud_count . ' trial(s) remaining';
                        Session::add('error', $error_msg);
                        return view('user/contribute');
                    }
                }elseif ($is_pin_valid->status === 'used'){
                    $error_msg = 'This pin has already been used';
                    Session::add('error', $error_msg);
                    return view('user/contribute');

                } elseif ($is_pin_valid->status === 'pending') {
                    $error_msg = 'This transaction with this pin is yet to be resolved';
                    Session::add('error', $error_msg);
                    return view('user/contribute');
                }else{
                    // Log information and make API call to the bank to fulfill the request
                    ContributionController::mark_contribution($request, $is_registered_customer, $is_pin_valid, false);
                }
            }
        }
    }

    private static function is_fraudulent($number){
        $query = "SELECT * FROM fraud WHERE phone = ". $number ." AND TIMESTAMPDIFF(MINUTE, updated_at, CURRENT_TIMESTAMP) < 30 ORDER BY updated_at DESC LIMIT 1";
        $status = Capsule::select($query);
        if(count($status) != 0){
            if($status[0]->fraud_status == 1){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    private static function update_fraud_count($number){
        // Update fraud count and return trials remaining and
        $count = Capsule::select("SELECT trials FROM fraud WHERE phone =". $number . " AND TIMESTAMPDIFF(MINUTE, updated_at, CURRENT_TIMESTAMP) < 30 ORDER BY updated_at DESC LIMIT 1");
        if(count($count) != 0 || $count != false){
            $trial =  (int)$count[0]->trials;
            if($trial == 2){
                // Update fraud count and set fraud status to true
                $update_fraud = Capsule::update("UPDATE fraud SET trials = 3, fraud_status = 1 WHERE phone = $number ORDER BY updated_at DESC LIMIT 1");
                if($update_fraud){
                    return true;
                }
            }else{
                $trial += 1;
                // Update trial count
                $update_fraud = Capsule::update("UPDATE fraud SET trials = $trial WHERE phone = $number ORDER BY updated_at DESC LIMIT 1");
                if($update_fraud){
                    return 1;
                }
            }
        }else{
            $log_fraud = Capsule::insert("INSERT INTO fraud (phone, trials, fraud_status) VALUES ('$number', 1, 0)");
            if($log_fraud){
                //Remaining trials before block
                return 2;
            }
        }

    }

    public function ussd(){
        if(Request::has('post')) {
            $request = Request::get('post');
            $sessionId = $request->sessionId;
            $serviceCode = $request->serviceCode;
            $phoneNumber = $this->format_phone($request->phoneNumber);
            $text = $request->text;
            header('Content-type: text/plain');

            // time for some validation
            //Validation Rules
            $rules = [
                'phoneNumber' => ['required' => true,'maxLength' => 14, 'minLength' => 11],
                'pin' => ['required' => true,'minLength' => 12, 'maxLength' => 20, 'number' => true],
                'sessionId' => ['required' => true, 'mixed' => true],
                'serviceCode' => ['required' => true],
                'text' => ['ussd_string' => true],
            ];

            //Run Validation and return errors
            $validation = new Validation();
            $validation->validate($_POST, $rules);
            if($validation->hasError()){
//                $errors = $validation->getErrorMessages();
//                $err = '';
//                foreach ($errors as $error){
//                    $err .= $error ."\n";
//                }
                $response = 'END Request not understood. Make sure you are registered and pin is typed correctly';
                echo $response;
                exit;
            }

            $level = explode("*", $text);
            //Check if number is registered
            $is_registered_customer = Order::where('phone', '=', $phoneNumber)->first();
            if ($is_registered_customer == null) {
                $response = 'END This number is not registered';
                echo $response;
                exit;
            }
            // Check if number has been logged for fraud for less than 30mins
            $fraud_status = ContributionController::is_fraudulent($phoneNumber);
            if ($fraud_status == true) {
                $response = 'END This number has been banned from using this service';
                echo $response;
                exit;
            }
            $encryption = new Encryption();
            if (isset($text) && $text == '') {
                $response = 'CON Please enter your Fastrak pin';
                echo $response;
                exit;
            } elseif(isset($text) && $text != '') {
                //The first item in the array should be the pin
                $no_of_items_in_array = count($level);
                if ($no_of_items_in_array === 1) {

                    $pin = $level[0];
                    $pin = $encryption->encrypt($pin);

                    $is_pin_valid = Pin::find($pin);
                    if ($is_pin_valid == NULL) {
                        $fraud_count = ContributionController::update_fraud_count($phoneNumber);
                        // If fraud count returns true, it means this douche bag has tried an invalid pin up to 3 times
                        if ($fraud_count === true) {
                            $response = 'END You have been barred from using this service';
                            echo $response;
                            exit;
                        } else {
                            $response = 'CON Wrong Pin! You have only ' . $fraud_count . ' trial(s) remaining';
                            echo $response;
                            exit;
                        }
                    } elseif ($is_pin_valid->status === 'used'){
                        $response = 'END This pin has already been used';
                        echo $response;
                        exit;
                    } elseif ($is_pin_valid->status === 'pending'){
                        $response = 'END This transaction with this pin is yet to be resolved';
                        echo $response;
                        exit;
                    }else {
                        $response = "CON You're about to deposit ₦" . $is_pin_valid->amount . " in your savings.\n";
                        $response .= "1. Proceed\n";
                        $response .= "2. Cancel\n";
                        echo $response;
                        exit;
                    }
                } elseif ($no_of_items_in_array === 2 or $no_of_items_in_array <= 4) {
                    // check if the user is trying to confirm a pin transaction
                    $confirmation = end($level);
                    if ($confirmation === '1') {
                        //Transaction confirmed, you'll be notified

                        $pin = prev($level);
                        $pin = $encryption->encrypt($pin);
                        $is_pin_valid = Pin::find($pin);
                        if ($is_pin_valid == NULL) {
                            $fraud_count = ContributionController::update_fraud_count($phoneNumber);
                            // If fraud count returns true, it means this douche bag has tried an invalid pin up to 3 times
                            if ($fraud_count === true) {
                                $response = 'END You have been barred from using this service';
                                echo $response;
                                exit;
                            } else {
                                $response = 'CON Wrong Pin! You have only ' . $fraud_count . ' trial(s) remaining';
                                echo $response;
                                exit;
                            }
                        }elseif ($is_pin_valid->status === 'used'){
                            $response = 'END This pin has already been used';
                            echo $response;
                            exit;
                        } elseif ($is_pin_valid->status === 'pending'){
                            $response = 'END This transaction with this pin is yet to be resolved';
                            echo $response;
                            exit;
                        }else {
                            ContributionController::mark_contribution($request, $is_registered_customer, $is_pin_valid);
                            $response = 'END Transaction successful, You will be credited shortly.';
                            echo $response;
                            exit;

                        }

                    } elseif (end($level) === '2') {
                        // It means the user has cancelled the transaction
                        $response = 'END was Transaction terminated';
                        echo $response;
                        exit;
                    } else {
                        // This should be another pin
                        $pin = end($level);
                        $pin = $encryption->encrypt($pin);
                        $is_pin_valid = Pin::find($pin);
                        if ($is_pin_valid == NULL) {
                            $fraud_count = ContributionController::update_fraud_count($phoneNumber);
                            // If fraud count returns true, it means this douche bag has tried an invalid pin up to 3 times
                            if ($fraud_count === true) {
                                $response = 'END You have been barred from using this service';
                                echo $response;
                                exit;
                            } else {
                                $response = 'CON Wrong Pin! You have only ' . $fraud_count . ' trial(s) remaining';
                                echo $response;
                                exit;
                            }
                        } else {
                            $response = "CON You're about to deposit ₦" . $is_pin_valid->amount . " in your savings.\n";
                            $response .= "1. Proceed\n";
                            $response .= "2. Cancel\n";
                            echo $response;
                            exit;
                        }
                    }
                } else {
                    $response = 'END There is a problem with this request, please try again';
                    echo $response;
                    exit;
                }
            }
        }else{
            $response = 'END Invalid request';
            echo $response;
            exit;
        }
    }

    private function mark_contribution($request,$is_registered_customer, $is_pin_valid, $ussd = true){
        if($ussd === true){
            // the Request of Africas talking is phone is phoneNumber, I need to reassign
            $request->phone = ContributionController::format_phone($request->phoneNumber);
            $request->pin = $is_pin_valid->pin;
        }
        $last_contribution = Contribution::where('phone', $request->phone)->latest('id')->first();

        $pin_amount = (int)$is_pin_valid->amount;
        $daily_amount = (int)$is_registered_customer->amount;

        $points = $pin_amount / $daily_amount;
        if($last_contribution ==  null){

            if($points <= 31.0){
                Contribution::create([
                    'contribution_id' => Random::generateId(16),
                    'phone' => $request->phone,
                    'pin' => $request->pin,
                    'ledger_bal' => $pin_amount,
                    'available_bal' => $pin_amount,
                    'points' => $points,
                ]);
                $is_pin_valid->status = 'used';
                $is_pin_valid->save();
            }else {
                $first_store = array();
                while($points > 0){
                    //die('Remaining points is ' . $remaining_points);
                    if($points > 31.0){
                        $ledger_bal = 31 * $daily_amount;
                        $available_bal = (31 * $daily_amount) - $daily_amount;
                        $cid = Random::generateId(16);
                        $first_store[] = array(
                            'contribution_id' => $cid,
                            'phone' => $request->phone,
                            'pin' => $request->pin,
                            'ledger_bal' =>  $ledger_bal,
                            'available_bal' =>  $available_bal,
                            'points' => 31.0,
                        );
                        $points = $points - 31.0;
                    }else{

                        $remaining_points = $points % 31;
                        $remaining_bal = $remaining_points * $daily_amount;
                        $cid = Random::generateId(16);
                        $first_store[] = array(
                            'contribution_id' => $cid,
                            'phone' => $request->phone,
                            'pin' => $request->pin,
                            'ledger_bal' =>  $remaining_bal,
                            'available_bal' =>  $remaining_bal,
                            'points' => $remaining_points,
                        );
                        $points = 0;
                    }
                }
                Contribution::insert($first_store);
                $is_pin_valid->status = 'used';
                $is_pin_valid->save();
            }
            //Send info to bank await confirmation

            if($ussd === false){
                Session::add('success', 'Contribution logged successfully');
                return view('user/contribute');
            }
        }else{
            $accumulator = $points + $last_contribution->points;
            if($accumulator < 31.0){

                Contribution::create([
                    'contribution_id' => Random::generateId(16),
                    'phone' => $request->phone,
                    'pin' => $request->pin,
                    'ledger_bal' => $pin_amount,
                    'available_bal' => $pin_amount,
                    'points' => $accumulator,
                ]);
                $is_pin_valid->status = 'used';
                $is_pin_valid->save();
                if($ussd === false) {
                    Session::add('success', 'Contribution logged successfully');
                    return view('user/contribute');
                }

            }elseif($accumulator == 31.0){

                Contribution::create([
                    'contribution_id' => Random::generateId(16),
                    'phone' => $request->phone,
                    'pin' => $request->pin,
                    'ledger_bal' => $pin_amount,
                    'available_bal' => $pin_amount - $daily_amount,
                    'points' => $accumulator,
                ]);
                $is_pin_valid->status = 'used';
                $is_pin_valid->save();
                if($ussd === false) {
                    Session::add('success', 'Contribution logged successfully. Cycle completed');
                    return view('user/contribute');
                }
            }elseif($accumulator > 31.0){

                $rem_points_to_complete_last_contribution = 31.0 - $last_contribution->points;
                $rem_to_complete_last_amount = $rem_points_to_complete_last_contribution * $daily_amount;

                if($rem_points_to_complete_last_contribution == 0 ){
                    if($points <= 31.0){
                        Contribution::create([
                            'contribution_id' => Random::generateId(16),
                            'phone' => $request->phone,
                            'pin' => $request->pin,
                            'ledger_bal' => $pin_amount,
                            'available_bal' => $pin_amount,
                            'points' => $points,
                        ]);
                        $is_pin_valid->status = 'used';
                        $is_pin_valid->save();
                    }else {
                        $first_store = array();
                        while($points > 0){
                            //die('Remaining points is ' . $remaining_points);
                            if($points > 31.0){
                                $ledger_bal = 31 * $daily_amount;
                                $available_bal = (31 * $daily_amount) - $daily_amount;
                                $cid = Random::generateId(16);
                                $first_store[] = array(
                                    'contribution_id' => $cid,
                                    'phone' => $request->phone,
                                    'pin' => $request->pin,
                                    'ledger_bal' =>  $ledger_bal,
                                    'available_bal' =>  $available_bal,
                                    'points' => 31.0,
                                );
                                $points = $points - 31.0;
                            }else{
                                $remaining_points = $points;
                                $remaining_bal = $remaining_points * $daily_amount;
                                $cid = Random::generateId(16);
                                $first_store[] = array(
                                    'contribution_id' => $cid,
                                    'phone' => $request->phone,
                                    'pin' => $request->pin,
                                    'ledger_bal' =>  $remaining_bal,
                                    'available_bal' =>  $remaining_bal,
                                    'points' => $remaining_points,
                                );
                                $points = 0;
                            }
                        }
                        Contribution::insert($first_store);
                        $is_pin_valid->status = 'used';
                        $is_pin_valid->save();
                    }
                    if($ussd === false) {
                        Session::add('success', 'Contribution logged successfully.');
                        return view('user/contribute');
                    }
                }elseif($rem_points_to_complete_last_contribution > 0  and $points <= 31.0){
                    $remainder_to_store = array();
                    $remainder_to_store[] = array(
                        'contribution_id' => Random::generateId(16),
                        'phone' => $request->phone,
                        'pin' => $request->pin,
                        'ledger_bal' =>  $rem_to_complete_last_amount,
                        'available_bal' =>   $rem_to_complete_last_amount - $daily_amount,
                        'points' => $rem_points_to_complete_last_contribution + $last_contribution->points,
                    );

                    // Minus the remaining amount in
                    $remaining_points = $points - $rem_points_to_complete_last_contribution;
                    $remaining_amount = $pin_amount - $rem_to_complete_last_amount;

                    $cid = Random::generateId(16);
                    $remainder_to_store[] = array(
                        'contribution_id' => $cid,
                        'phone' => $request->phone,
                        'pin' => $request->pin,
                        'ledger_bal' =>  $remaining_amount,
                        'available_bal' =>  $remaining_amount,
                        'points' => $remaining_points,
                    );

                    Contribution::insert($remainder_to_store);
                    $is_pin_valid->status = 'used';
                    $is_pin_valid->save();
                    if($ussd === false) {
                        Session::add('success', 'Contribution logged successfully.');
                        return view('user/contribute');
                    }
                }elseif($rem_points_to_complete_last_contribution > 0  and $points > 31.0){
                    Contribution::create([
                        'contribution_id' => Random::generateId(16),
                        'phone' => $request->phone,
                        'pin' => $request->pin,
                        'ledger_bal' =>  $rem_to_complete_last_amount,
                        'available_bal' =>   $rem_to_complete_last_amount - $daily_amount,
                        'points' => $rem_points_to_complete_last_contribution + $last_contribution->points,
                    ]);
                    // Run a for loop through the remaining amount in case it is more than one cycle
                    $remaining_points = $points - $rem_points_to_complete_last_contribution;
                    $remaining_amount = $pin_amount - $rem_to_complete_last_amount;

                    $remainder_to_store = array();
                    while($remaining_points > 0){
                        if($remaining_points > 31.0){
                            $ledger_bal = 31 * $daily_amount;
                            $available_bal = (31 * $daily_amount) - $daily_amount;
                            $cid = Random::generateId(16);
                            $remainder_to_store[] = array(
                                'contribution_id' => $cid,
                                'phone' => $request->phone,
                                'pin' => $request->pin,
                                'ledger_bal' =>  $ledger_bal,
                                'available_bal' =>  $available_bal,
                                'points' => 31.0,
                            );
                            $remaining_points = $remaining_points - 31.0;
                        }else{
                            $remaining_bal = $remaining_points * $daily_amount;
                            $cid = Random::generateId(16);
                            $remainder_to_store[] = array(
                                'contribution_id' => $cid,
                                'phone' => $request->phone,
                                'pin' => $request->pin,
                                'ledger_bal' =>  $remaining_bal,
                                'available_bal' =>  $remaining_bal,
                                'points' => $remaining_points,
                            );
//                                        echo 'Remaining balance is ' . $remaining_bal;
//                                        die('Remaining points is ' . $remaining_points);
                            $remaining_points = 0;
                        }
                    }

                    Contribution::insert($remainder_to_store);
                    $is_pin_valid->status = 'used';
                    $is_pin_valid->save();
                    if($ussd === false) {
                        Session::add('success', 'Contribution logged successfully.');
                        return view('user/contribute');
                    }
                }
            }
        }
    }

    public function search_contribution($terms){
        //Get the value of the term from the array
        $term = trim($terms['terms']);
        $searchresult = Contribution::query()
            ->where('phone', 'LIKE', "%{$term}%")
            ->orWhere('pin', 'LIKE', "%{$term}%")->get();

        if(!empty($searchresult) and count($searchresult) > 0){
            echo json_encode(['success' => $searchresult]);
            exit();
        }else{
            echo json_encode(['error' => 'No result found']);
            exit();
        }

    }

    public static function validate_ussd_text($value){
        if($value != null && !empty(trim($value))){
            if(!preg_match('/^[0-9 *]+$/', $value)){
                return false;
            }
        }
        return true;
    }

    public function is_valid_phoneNumber($phoneNumber){
        if(!strlen($phoneNumber) === 11){
            return false;
        }
        return true;
    }

    public function format_phone($phone, $country="NGN"){
        switch ($country){
            case 'NGN':
                $stripped_sign = preg_replace("/[^0-9]/", '', $phone);
                $phone = preg_replace("/^234/", "0", $stripped_sign);
                return $phone;
                break;

            default;
        }
    }
}