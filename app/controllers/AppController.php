<?php

namespace App\Controllers;


use App\Models\District;
use App\Models\Order;
use App\Models\Event;
use App\Models\Rider;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;


class AppController extends BaseController{
    public $uploadDir = 'fd';

    public function appLogin(){
        $data =  json_decode(file_get_contents("php://input"));

        if(!empty($data->email) and !empty($data->password)){
            if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)){
                http_response_code(400);
                echo json_encode(array("error" => "Invalid email"));
                exit();
            }
            $user = User::where('email', $data->email)->first();
            if($user){
                if(!password_verify($data->password, $user->password)){
                    http_response_code(400);
                    echo json_encode(array("error" => "Incorrect password"));
                    exit();
                }else{
                    $secret_key = "UPDEL";
                    $issuer_claim = $_SERVER['SERVER_NAME']; // this can be the servername
                    $audience_claim = "THE_AUDIENCE";
                    $issuedat_claim = time(); // issued at
                    $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                    $expire_claim = $issuedat_claim + (60 * 60 * 24 * 5); // expire time in seconds
                    $token = array(
                        "iss" => $issuer_claim,
                        "aud" => $audience_claim,
                        "iat" => $issuedat_claim,
                        "nbf" => $notbefore_claim,
                        "exp" => $expire_claim,
                        "data" => array(
                            "userid" =>  $user->user_id,
                            "firstname" => $user->firstname,
                            "email" => $user->email
                        ));
                    http_response_code(200);
                    $jwt = JWT::encode($token, $secret_key);

                    echo json_encode(array("status" => 'success',
                        'jwt' => $jwt,
                        'username' => $user->firstname,
                        'image' => $user->image));
                    exit();
                }
            }else{
                http_response_code(401);
                echo json_encode(array("error" => "Invalid credentials"));
                exit();
            }

        }else{
            http_response_code(400);
            echo json_encode(array("error" => "Both email and password are required."));
        }
    }

    public function verifyJWT(){
        $secret_key = "UPDEL";
        $jwt = null;

        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        $arr = explode(" ", $authHeader);

        $jwt = $arr[1];

        if ($jwt) {

            try {

                $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
                return $decoded;

            } catch (Exception $e) {

                http_response_code(401);

                echo json_encode(array(
                    "status" => "failed",
                    "message" => "Access denied.",
                    "error" => $e->getMessage()
                ));
            }

        }
    }

    /**
     *
     */
    public function getRiderDistrict(){
        $decoded = $this->verifyJWT();
        if($decoded->data->userid !== null or $decoded->data->userid !== '' or $decoded->status !== 'failed'){
            $district = Rider::where('user_id', $decoded->data->userid)->with(['districts'])->get();
            echo json_encode(array(
                "message" => "Access granted:",
                "data" =>  $district,

            ));
        }else{
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => "Authentication failed"
            ));
        }


    }

    public function getRiderOrders(){
        $decoded = $this->verifyJWT();
        if($decoded->data->userid !== null or $decoded->data->userid !== '' or $decoded->status !== 'failed'){
            $district = Rider::where('user_id', $decoded->data->userid)->with(['orders'])->get();
            echo json_encode(array(
                "status" => "Success",
                "data" =>  $district,
            ));
        }else{
            echo json_encode(array(
                "status" => "Error",
                "error" => "Authentication failed"
            ));
        }
    }

    public function uploadSignature($signature){
        $ds = DIRECTORY_SEPARATOR;
        $target_path = BASE_PATH."{$ds}public{$ds}img{$ds}signatures{$ds}";
        $img_data = str_replace('data:image/png;base64,', '', $signature);
        $img_data = str_replace(' ', '+', $img_data);
        $data = base64_decode($img_data);

        $img_name = $data->order_no . uniqid()  . '.png';
        $success = file_put_contents($target_path . $img_name, $img_data);
        return $success ? $target_path . $img_name : false;
    }

    public function updateOrder(){
        $decoded = $this->verifyJWT();
        if($decoded->data->userid !== null or $decoded->data->userid !== '' or $decoded->status !== 'failed'){

            $data = json_decode(file_get_contents("php://input"));
            if(!empty($data->order_no) and !empty($data->status)){


                try{
                    $order = Order::where('order_no', $data->order_no)->first();

//                    $order->order_status = $data->status;
                    if($data->status == 'unsuccessful'){
                        $order->order_status = $data->status;
                        $order->save();
                        $details = [
                            'user_id' => $decoded->data->userid,
                            'order_no' => $data->order_no,
                            'status' => $data->status,
                            'comment' => $data->comment
                        ];
                        Event::create($details);
                        http_response_code(201);

                        echo json_encode(array(
                            "status" => "Success",
                            "message" => "Order status updated successfully",
                            "data" =>  [],
                        ));
                        exit();
                    }elseif ($data->status == 'completed'){
                        if($order->request_type == 'collection'){
                            try{
                                $img_name = $this->uploadSignature($data->collector_signature);
                                if($img_name === false){
                                    echo json_encode(array(
                                        "status" => "Error",
                                        "message" => 'Signature upload failed',
                                        "data" =>  [],
                                    ));
                                    exit();
                                }
                            }catch (Exception $e){
                                echo json_encode(array(
                                    "status" => "Error",
                                    "message" => $e->getMessage(),
                                    "data" =>  [],
                                ));
                            }
                             $order->collector_name = $data->collector_name;
                             $order->collector_signature = $img_name;
                             $order->order_status = $data->status;
                             $order->save();

                            $details = [
                                'user_id' => $decoded->data->userid,
                                'order_no' => $data->order_no,
                                'status' => $data->status,
                                'comment' => 'Order delivered successfully'
                            ];
                            Event::create($details);

                            http_response_code(201);

                            echo json_encode(array(
                                "status" => "Success",
                                "message" => "Order status updated successfully",
                                "data" =>  [],
                            ));
                        }else{
                            try{
                                $img_name = $this->uploadSignature($data->delivered_signature);
                                if($img_name === false){
                                    echo json_encode(array(
                                        "status" => "Error",
                                        "message" => 'Signature upload failed',
                                        "data" =>  [],
                                    ));
                                    exit();
                                }
                            }catch (Exception $e){
                                echo json_encode(array(
                                    "status" => "Error",
                                    "message" => $e->getMessage(),
                                    "data" =>  [],
                                ));
                            }

                            $order->delivered_name = $data->delivered_name;
                            $order->delivered_signature = $img_name;
                            $order->delivery_mode = $data->delivery_mode;
                            $order->order_status = $data->status;
                            $order->save();

                            $details = [
                                'user_id' => $decoded->data->userid,
                                'order_no' => $data->order_no,
                                'status' => $data->status,
                                'comment' => 'Order delivered successfully'
                            ];
                            Event::create($details);

                            http_response_code(201);

                            echo json_encode(array(
                                "status" => "Success",
                                "message" => "Order status updated successfully",
                                "data" =>  [],
                            ));
                        }
                    }elseif ($data->status == 'halfdone'){
                        try{
                            $img_name = $this->uploadSignature($data->collector_signature);
                            if($img_name === false){
                                echo json_encode(array(
                                    "status" => "Error",
                                    "message" => 'Signature upload failed',
                                    "data" =>  [],
                                ));
                                exit();
                            }
                        }catch (Exception $e){
                            echo json_encode(array(
                                "status" => "Error",
                                "message" => $e->getMessage(),
                                "data" =>  [],
                            ));
                        }

                        $order->collector_name = $data->collector_name;
                        $order->collector_signature = $img_name;
                        $order->order_status = $data->status;
                        $order->save();
                        $comment = '';
                        if($order->request_type == 'combo'){
                            $comment = 'Request has been collected, rider on route to delivery';
                        }else{
                            $comment = 'Request has been collected, rider on route to swap collected item';
                        }

                        $details = [
                            'user_id' => $decoded->data->userid,
                            'order_id' => $data->order_no,
                            'status' => $data->status,
                            'comment' => $comment
                        ];
                        Event::create($details);

                        http_response_code(201);
                        echo json_encode(array(
                            "status" => "Success",
                            "message" => "Order status updated successfully",
                            "data" =>  [],
                        ));
                    }



                }catch (Exception $e){
                    echo json_encode(array(
                        "status" => "Error",
                        "message" => $e->getMessage(),
                        "data" =>  [],
                    ));
                }
            }

        }else{
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => "Authentication failed"
            ));
        }
    }

    public function profile(){
        $decoded = $this->verifyJWT();
        if($decoded->data->userid !== null or $decoded->data->userid !== '' or $decoded->status !== 'failed'){
            $user = User::where('user_id', $decoded->data->userid)->first();
            echo json_encode(array(
                "status" => "Success",
                "message" => "Access granted:",
                "data" =>  $user,

            ));
        }else{
            echo json_encode(array(
                "message" => "Access denied.",
                "error" => "Authentication failed"
            ));
        }
    }

    public function track(){

        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->order_no)) {
            $order = Order::where('order_no', $data->order_no)->with(['route', 'events'])->first();

            if($order !== null){
                http_response_code(200);
                echo json_encode(array(
                    "status" => "Success",
                    "message" => '',
                    "data" =>  $order,
                ));
                exit();
            }else{
                http_response_code(404);
                echo json_encode(array(
                    "message" => "Order number not found",
                    "status" => "Error"
                ));
                exit();
            }

        }else{
            http_response_code(400);
            echo json_encode(array(
                "message" => "Order number is empty",
                "status" => "Error"
            ));
        }
    }

}