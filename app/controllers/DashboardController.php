<?php


namespace App\Controllers;

use App\Classes\CSRFToken;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\Validation;
use App\Models\District;
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
        $total_orders = Order::all()->count();

        // Total completed
        $total_completed = Order::where('order_status', '=', ['completed', 'delivered'])->count();

        // Total ongoing
        $total_ongoing = Order::where('order_status', 'ongoing')->count();

        // Total pot
        $total_pot = Order::where('order_status', '=', ['uncompleted', 'abandoned'])->count();

        $priviledge = Session::get('priviledge');
        $state = Session::get('state');
        if($priviledge === 'Manager'){
            $latest_order = District::where('state', $state)->with(['orders'=>  function($query) {
                                                                    $query->take(2)->orderBy('id', 'desc')->get();
                                                                    }])->get();
        }else{
            $latest_order = District::with(['orders' =>  function($query) {
                                            $query->take(5)->orderBy('id', 'desc')->get();
                                            }])->get();
        }

//        $latest_order = Order::take(15)->orderBy('id', 'desc')->get();

        // TODO: Doughnut pie of channel used
        return view('user.dashboard',
            ['total_orders'=> $total_orders,
                                            'total_completed' => $total_completed,
                                            'total_ongoing' => $total_ongoing,
                                            'total_pot' => $total_pot,
                                            'orders' => $latest_order]
        );
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