<?php


namespace App\controllers;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Classes\CSRFToken;
use App\Classes\Random;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\Validation;
use App\Models\District;
use App\Models\Route;

class DistrictController extends BaseController{
    public function get_district(){
        $districts = District::all();
        $routes = Route::all();
        return view('user\district', ['districts' => $districts, 'routes' => $routes]);
    }

    public function store_district(){
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $rules = [
                    'name' => ['required' => true,'string' => true, 'minLength' => 2, 'maxLength' => 100,'unique' =>'districts'],
                ];
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    $errors = $validation->getErrorMessages();
                    return view('user\district', ['errors' => $errors]);
                }

                //Add the user
                $details = [
                    'district_id' => Random::generateId(16),
                    'name' => $request->name,
                    'created_by' => Session::get('SESSION_USERNAME'),
                ];
                District::create($details);
                Request::refresh();
                Session::add('success', 'New district created successfully');
                Redirect::to('/district_routes');
                exit();
            }

            Session::add('error', 'District creation failed, try again');
            Redirect::to('/district_routes');
            exit();
        }
    }

    public function store_route(){
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $rules = [
                    'name' => ['required' => true, 'minLength' => 2, 'maxLength' => 100],
                    'district' => ['required' => true],
                ];
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    $errors = $validation->getErrorMessages();
                    return view('user\district', ['errors' => $errors]);
                }

                $district = Capsule::table('districts')->where('district_id',$request->district)->first();

                $district = $district->name;

                //Add the user
                $details = [
                    'district_id' => $request->district,
                    'district' => $district,
                    'route_id' => Random::generateId(16),
                    'name' => $request->name,
                    'created_by' => Session::get('SESSION_USERNAME'),
                ];
                Route::create($details);
                Request::refresh();
                Session::add('success', 'New route created successfully');
                Redirect::to('/district_routes');
                exit();
            }

            Session::add('error', 'Route creation failed, try again');
            Redirect::to('/district_routes');
            exit();
        }
    }

    public function edit_route($id){
        $route_id = $id['route_id'];
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token, false)){
                $rules = [
                    'district' => ['required' => true],
                    'district_id' => ['required' => true],
                    'name' => ['required' => true],
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
                    'district_id' => $request->district_id,
                    'district' => $request->district,
                    'name' => $request->name,
                ];
                try{
                    Route::where('route_id', $route_id)->update($details);
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

    public function delete_route($id){
        $route_id = $id['route_id'];

        if(Request::has('post')){
            $request = Request::get('post');

            if(CSRFToken::verifyCSRFToken($request->token)){

                $route = Route::where('route_id', '=', $route_id)->first();
                $route->delete();
                Session::add('success', 'Route deleted successfully');
                Redirect::to('/district_routes');
            }
//            Session::add('error', 'Customer deletion failed');
//            Redirect::to('/customers');
        }else{
            echo 'request error';
        }
    }

    public function edit_district(){

    }

    public function delete_district(){

    }
}