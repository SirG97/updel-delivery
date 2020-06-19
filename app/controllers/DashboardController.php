<?php


namespace App\Controllers;

use App\Classes\CSRFToken;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Validation;
use App\Models\Order;
use App\Models\Pin;
use App\Models\Contribution;
use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;

class DashboardController extends BaseController{
    public function __construct()
    {
        if(!isAuthenticated()){
            Redirect::to('/login');
        }
    }
    public function show(){
        // TODO: Total customer
//        $total_customer = Order::all()->count();
//
//        // Total saved
//        $total_saved_ledger = "SELECT SUM(ledger_bal) total_saved FROM contributions";
//        $total_ledger = Capsule::select($total_saved_ledger);
//        $total_saved = $total_ledger[0]->total_saved;
//
//        // Total revenue generated
//
//        $total_saved_available = "SELECT SUM(available_bal) total FROM contributions";
//        $total_available = Capsule::select($total_saved_available);
//        $total_revenue = $total_ledger[0]->total_saved - $total_available[0]->total;
//
//        //  Total Total number of pins
//        $total_pins = Pin::all()->count();
//
//        //  Number generated vs used for 10 days period -bar or line chart
//        $live_pins = "SELECT created_at, count(pin) as generated_pin
//                            FROM pins
//                            WHERE status = 'live'
//                            AND created_at >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
//                            GROUP BY created_at;";
//        $get_live_pins = Capsule::select($live_pins);
//        $used_pins = "SELECT created_at, count(pin) as generated_pin
//                            FROM pins
//                            WHERE status = 'used'
//                            AND created_at >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
//                            GROUP BY created_at;";
//        $get_used_pins = Capsule::select($used_pins);
//
//        $get_contribution_count = "SELECT count(*) daily_total
//                                    FROM contributions
//                                    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
//                                    GROUP BY DATE(created_at)";
//
//        $contribution_count = Capsule::select($get_contribution_count);
//        // TODO: Extract the data from the query
//
//        $latest_contributions = Contribution::orderBy('id', 'desc')->take(10)->get();

        // TODO: Doughnut pie of channel used
        return view('user\dashboard');
    }

    public function chart_info(){
            $get_contribution_count = "SELECT count(*) daily_total, created_at
                                    FROM contributions 
                                    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                                    GROUP BY DATE(created_at)";

            $contribution_count = Capsule::select($get_contribution_count);
            if($contribution_count){
                echo json_encode(['success' => 'Chart data retrieved successfully', 'contribution_count' => $contribution_count]);
                exit();
            }

            echo json_encode(['error' => 'Could not get chart data']);
            exit();

    }

    public function get(){
        $data = Request::old('post', 'name');
        $request = Request::get('post');

    }

    public function store(){

        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                var_dump('hia chim oo');

                $rules = [
                    'surname' => ['required' => true, 'maxLength' => 7, 'string' => true, 'unique' =>'users']
                ];
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    var_dump($validation->getErrorMessages());
                    exit();
                }

                return view('user/dashboard', compact('error'));

            }

            throw new \Exception('Token mismatch');



        }


    }


}