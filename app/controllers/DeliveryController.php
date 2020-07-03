<?php

namespace App\Controllers;


use App\Models\Authorization;
use App\Models\Route;
use App\Models\User;
use App\Models\Rider;
use App\Models\District;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Classes\CSRFToken;
use App\Classes\Random;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\Validation;




class DeliveryController extends BaseController {
    public function __construct(){
        if(!isAuthenticated()){
            Redirect::to('/login');
        }
    }

    public function get_authorization_page(){
        $id = Session::get('SESSION_USER_ID');
        $qr_code = Authorization::where('user_id', $id)->first();

        return view('user\authorizedelivery', ['qr_code' => $qr_code]);
    }

    public function generate_authorization_qr_code(){
        if(Request::has('post')) {
            $request = Request::get('post');
            if (CSRFToken::verifyCSRFToken($request->token)) {
                $barcode = new \Com\Tecnick\Barcode\Barcode();
                try{
                    $qr_code = $barcode->getBarcodeObj('QRCODE,H',
                        "{$request->user_id}",
                        300,
                        300,
                        'black',
                        array(0, 0, 0, 0));
                    $qr_code_image = $qr_code->getPngData();
                    $ds = DIRECTORY_SEPARATOR;
                    $target_path = BASE_PATH."{$ds}public{$ds}img{$ds}qrcode{$ds}";
                    $timestamp = time();
                    $img_name = $request->user_id . $timestamp  . '.png';
                    file_put_contents($target_path . $img_name, $qr_code_image);
                    // Save to DB
                    $image_path = "img{$ds}qrcode{$ds}" . $img_name;
                    Authorization::updateOrCreate([
                        'user_id' => $request->user_id],[
                        'auth_img' => $image_path,

                    ]);
                    Session::add('success', 'QR code created successfully');
                    Redirect::back();
                }catch (\Exception $e){
                    Session::add('error', 'QR code could not be generated');
                    Redirect::back();
                    exit();
                }

            }
            Redirect::back();
        }
    }

    public function authorize_delivery(){

    }

   public function get_assign_route(){
       $riders = User::where('admin_right', 'Rider')->orderBy('id','desc')->get();
        return view('user\assign_route', ['staffs' => $riders]);
   }

   public function get_rider_district($id){
        $id = $id['district_id'];
        $districts = District::all()->toArray();
        $assigned_districts = Rider::where('user_id', $id)->with(['districts'])->get();

       //Remove routes to select from the dropdown
       foreach($assigned_districts as $r){
           foreach ($r->districts as $v){
               $districts = $this->filter_dropdown( $districts, $v->district_id);
           }
       }

       $riders = User::where('user_id', $id)->first();
       return view('user\rider_routes', ['profile' => $riders, 'districts' => $districts, 'assigned_districts' => $assigned_districts]);
   }

   public function filter_dropdown($array, $value){
        $temp = [];
        foreach($array as $item){
            if($item['district_id'] !== $value){
                array_push($temp, $item);
            }
        }
        return $temp;
    }

   public function assign_route(){
       if(Request::has('post')) {
           $request = Request::get('post');
           if (CSRFToken::verifyCSRFToken($request->token)) {
               $rules = [
                   'district_to_assign' => ['required' => true, 'maxLength' => '50', 'mixed' => true],
                   'user_id' => ['required' => true, 'maxLength' => '50', 'mixed' => true],
               ];

               $validation = new Validation();
               $validation->validate($_POST, $rules);

               if($validation->hasError()){
                   $errors = $validation->getErrorMessages();
                   Session::add('error', $errors);
                   Redirect::back();
                   exit();
               }

               try{
                   $details = [
                       'user_id' => $request->user_id,
                       'rider_id' => Random::generateId(16),
                       'district_id' => $request->district_to_assign,
                       'assigned_by' => Session::get('SESSION_USERNAME'),
                       'assignee_status' => Session::get('priviledge'),
                   ];

                   Rider::create($details);
                   Request::refresh();
                   Session::add('success', 'District assigned successfully');
                   Redirect::back();
                   exit();
               }catch (\Exception $e){
                   Session::add('error', 'District could not be assigned');
                   dd($e);
                   Redirect::back();
                   exit();
               }

           }
           Redirect::back();
       }
   }

    public function delete_assigned_route($id){
        $rider_id = $id['rider_id'];

        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $rider = Rider::where('rider_id', '=', $rider_id)->first();
                $rider->delete();
                Session::add('success', 'District unassigned successfully');
                Redirect::back();
                exit();
            }
            Session::add('error', 'Operation failed, please try again.');
            Redirect::back();
        }else{
            Session::add('error', 'Operation failed, please try again.');
            Redirect::back();
        }
    }
}