<?php


namespace App\Controllers;


use App\Classes\Encryption;
use App\Models\District;
use App\Models\Route;
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

class OrderController extends BaseController{
    public $table_name = 'orders';
    public $customers;
    public $links;

    public function __construct()
    {
        if(!isAuthenticated()){
            Redirect::to('/login');
        }
    }

//    public function __construct(){
//        $total = Customer::all()->count();
////        $customers = Customer::all();
//        $object = new Customer();
//
//        list($this->customers, $this->links) = paginate(20, $total, $this->table_name, $object);
//    }

    public function show_orders(){
        $districts = District::all();
        $routes = Route::all();
        $orders = Order::all();
        return view('user\orders', [ 'orders' => $orders,'districts' => $districts, 'routes' => $routes]);
    }

    public function get_order_form(){
        $districts = District::all();
        $routes = Route::all();
        return view('user\order_form', ['districts' => $districts, 'routes' => $routes]);
    }

    public function save_order(){
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $rules = [
                    'request_type' => ['required' => true],
                    'district' => ['required' => true, 'maxLength' => 100, 'mixed' => true],
                    'route' => ['required' => true,'string' => true],
                    'fullname' => ['required' => true,'maxLength' => 50, ],
                    'address' => ['required' => true, 'maxLength' => 100],
                    'phone' => ['required' => true, 'maxLength' => '50'],
                    'parcel_name' => ['required' => true, 'maxLength' => '150'],
                    'parcel_size' => ['number' => true],
                    'pick_up_address' => ['required' => true],
                    'pick_up_landmark' => ['required' => true],
                    'delivery_address' => ['required' => true],
                    'delivery_landmark' => ['required' => true],
                    'description' => ['required' => true]
                ];
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    $errors = $validation->getErrorMessages();
                    return view('user\order_form', ['errors' => $errors]);
                }

                //Add the user
                $details = [
                    'order_no' => Random::generateId(16),
                    'request_type' => $request->request_type,
                    'district' => $request->district,
                    'route' => $request->route,
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'parcel_name' => $request->parcel_name,
                    'parcel_size' => $request->parcel_size,
                    'pick_up_address' => $request->pick_up_address,
                    'pick_up_landmark' => $request->pick_up_landmark,
                    'delivery_address' => $request->delivery_address,
                    'delivery_landmark' => $request->delivery_landmark,
                    'description' => $request->description,
                    'rider_id' => '',
                    'order_status' => 'registered'
                ];

                Order::create($details);
                Request::refresh();
                Session::add('success', 'New order created successfully');

                Redirect::to('/orders');
                exit();

            }

            Redirect::to('/orders');
        }
    }

    public function edit_order($id){
        $order_no = $id['order_no'];
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token, false)){
                $rules = [
                    'request_type' => ['required' => true],
                    'district' => ['required' => true, 'maxLength' => 100, 'mixed' => true],
                    'route' => ['required' => true,'string' => true],
                    'fullname' => ['required' => true,'maxLength' => 50, ],
                    'address' => ['required' => true, 'maxLength' => 100],
                    'phone' => ['required' => true, 'maxLength' => '50'],
                    'parcel_name' => ['required' => true, 'maxLength' => '150'],
                    'parcel_size' => ['number' => true],
                    'pick_up_address' => ['required' => true],
                    'pick_up_landmark' => ['required' => true],
                    'delivery_address' => ['required' => true],
                    'delivery_landmark' => ['required' => true],
                    'description' => ['required' => true]
                ];
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    $errors = $validation->getErrorMessages();
                    header('HTTP 1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($errors);
                    exit();
                }

                //Add the order details to an array
                $details = [
                    'request_type' => $request->request_type,
                    'district' => $request->district,
                    'route' => $request->route,
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'parcel_name' => $request->parcel_name,
                    'parcel_size' => $request->parcel_size,
                    'pick_up_address' => $request->pick_up_address,
                    'pick_up_landmark' => $request->pick_up_landmark,
                    'delivery_address' => $request->delivery_address,
                    'delivery_landmark' => $request->delivery_landmark,
                    'description' => $request->description,
                    'rider_id' => '',
                    'order_status' => 'registered'
                ];

                try{
                    Order::where('order_no', $order_no)->update($details);
                    echo json_encode(['success' => 'Route updated successfully']);
                    exit();
                }catch (\Exception $e){
                    header('HTTP 1.1 500 Server Error', true, 500);
                    echo json_encode(['error' => 'Route updated failed ' . $e]);
                    exit();
                }
            }else{
                echo 'token error';
            }

            //Redirect::to('/customer');
        }else{
            echo 'request error';
        }
    }

    public function show(){
        $total = Customer::all()->count();
        $object = new Customer();

        list($customers, $links) = paginate(20, $total, $this->table_name, $object);
        return view('user/customers', ['customers' => $customers, 'links' => $links]);
    }

    public function getcustomer($id){
        $customer_id = $id['customer_id'];

        $customer = Customer::where('customer_id', $customer_id)->first();

        $total = Contribution::where('phone', $customer->phone)->count();
        $object = new Contribution();
        $filter = ['phone' => $customer->phone];
        list($contributions, $links) = paginate(20,$total,'contributions', $object, $filter);

        $total_donation = 0;
        $total_available = 0;

        $all_contribution = Contribution::where('phone', $customer->phone)->get();
        for($i = 0; $i < count($all_contribution); $i++){
            $total_donation = $total_donation + (int)$all_contribution[$i]->ledger_bal;
            $total_available = $total_available + (int)$all_contribution[$i]->available_bal;
        }

        $maintenance = $total_donation - $total_available;

        return view('user/customerdetails', ['customer' =>$customer,
            'links' => $links,
            'contributions' => $contributions,
            'total_donation' => $total_donation,
            'total_available' => $total_available,
            'maintenance' => $maintenance]);
    }

    public function getcontribution($id){
        $contribution_id = $id['contribution_id'];
        return view('user/customercontributions');
    }


    public function showcustomerform(){
        return view('user/customer');
    }

    public function storecustomer(){
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){

                $rules = [
                    'email' => ['required' => true, 'maxLength' => 30, 'email' => true, 'unique' =>'customers'],
                    'firstname' => ['required' => true, 'maxLength' => 40, 'string' => true],
                    'surname' => ['string' => true, 'maxLength' => 40],
                    'phone' => ['required' => true,'maxLength' => 14, 'minLength' => 11, 'number' => true, 'unique' => 'customers'],
                    'city' => ['required' => true, 'maxLength' => '50', 'string' => true],
                    'state' => ['required' => true, 'maxLength' => '50', 'string' => true],
                    'address' => ['required' => true, 'maxLength' => '150'],
                    'amount' => ['required' => true,  'number' => true]
                ];
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    $errors = $validation->getErrorMessages();
                    return view('user/customer', ['errors' => $errors]);
                }

                //Add the user
                $details = [
                    'customer_id' => Random::generateId(16),
                    'surname' => $request->surname,
                    'firstname' => $request->firstname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'amount' => $request->amount,

                ];

                Customer::create($details);

                Request::refresh();

                Session::add('success', 'New customer created successfully');

                Redirect::to('/customers');
                exit();

            }

            Redirect::to('/customer');
        }
    }

    public function editcustomer($id){

        $customer_id = $id['customer_id'];
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token, false)){
                $rules = [
                    'email' => ['required' => true, 'maxLength' => 30, 'email' => true, 'unique_edit' => 'customers|' .$customer_id .'|customer_id'],
                    'firstname' => ['required' => true, 'maxLength' => 40, 'string' => true],
                    'surname' => ['string' => true, 'maxLength' => 40],
                    'phone' => ['required' => true,'maxLength' => 14, 'minLength' => 11],
                    'city' => ['required' => true, 'maxLength' => '50', 'string' => true],
                    'state' => ['required' => true, 'maxLength' => '50', 'string' => true],
                    'address' => ['required' => true, 'maxLength' => '150'],
                    'amount' => ['required' => true,  'number' => true]
                ];
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    $errors = $validation->getErrorMessages();
                    header('HTTP 1.1 422 Unprocessable Entity', true, 422);
                    echo json_encode($errors);
                    exit();
                }

                //Add the user
                $details = [
                    'surname' => $request->surname,
                    'firstname' => $request->firstname,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'amount' => $request->amount,

                ];

                Customer::where('customer_id', $customer_id)->update($details);
                echo json_encode(['success' => 'Customer details updated successfully']);
                exit();

            }else{
                echo 'token error';
            }

            //Redirect::to('/customer');
        }else{
            echo 'request error';
        }

    }

    public  function deletecustomer($id){
        $customer_id = $id['customer_id'];

        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCSRFToken($request->token)){

                $customer = Customer::where('customer_id', '=', $customer_id)->first();
                $customer->delete();
                Session::add('success', 'Customer deleted successfully');
                Redirect::to('/customers');
            }
//            Session::add('error', 'Customer deletion failed');
//            Redirect::to('/customers');
        }else{
            echo 'request error';
        }

    }

    public function searchcustomer($terms){
        //Get the value of the term from the array
        $term = trim($terms['terms']);
        $searchresult = Customer::query()
            ->where('surname', 'LIKE', "%{$term}%")
            ->orWhere('firstname', 'LIKE', "%{$term}%")
            ->orWhere('email', 'LIKE', "%{$term}%")
            ->orWhere('phone', 'LIKE', "%{$term}%")->get();
        if(count($searchresult) > 0){
            echo json_encode(['success' => $searchresult]);
            exit();
        }else{
            echo json_encode(['success' => 'No result found']);
            exit();
        }

    }

}