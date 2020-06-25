<?php

namespace App\Controllers;

use App\Classes\Encryption;
use App\Models\Authorization;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Classes\CSRFToken;
use App\Classes\Random;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\Validation;
use App\Models\Order;



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
                    Authorization::create([
                        'user_id' => $request->user_id,
                        'auth_img' => $image_path
                    ]);
                    Session::add('success', 'QR code created successfully');
                    return view('user\authorizedelivery', ['qr_code' => $image_path]);
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
        return view('user\assign_route');
   }


}