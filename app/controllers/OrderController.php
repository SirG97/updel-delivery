<?php


namespace App\Controllers;



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
use Carbon\Carbon;


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
        $orders = Order::orderBy('id', 'desc')->get();
        return view('user\orders', [ 'orders' => $orders,'districts' => $districts,]);
    }

    public function get_order($id){
        $order_no = $id['order_no'];
        $order = Order::where('order_no',$order_no)->with(['route'])->first();

        return view('user\order', ['order' => $order]);
    }

    public function get_routes($id){
        $id = $id['district_id'];
        $routes = Route::where('district_id', $id)->orderBy('id','desc')->get();
        echo json_encode($routes);
        exit;
    }

    public function get_order_form(){
        $districts = District::all();

        return view('user\order_form', ['districts' => $districts]);
    }

    public function save_order(){
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $rules = [
                    'request_type' => ['required' => true],
                    'service_type' => ['required' => true],
                    'email' => ['required' => true, 'email' => true],
                    'district' => ['required' => true, 'maxLength' => 100, 'mixed' => true],
                    'route' => ['required' => true,'mixed' => true],
                    'fullname' => ['required' => true,'maxLength' => 50, ],
                    'address' => ['required' => true, 'maxLength' => 100],
                    'phone' => ['required' => true, 'maxLength' => '50'],
                    'parcel_name' => ['required' => true, 'maxLength' => '150'],
                    'parcel_size' => ['number' => true],
                    'parcel_quantity' => ['number' => true],
                    'pick_up_address' => ['mixed' => true],
                    'pick_up_landmark' => ['mixed' => true],
                    'delivery_address' => ['mixed' => true],
                    'delivery_landmark' => ['mixed' => true],
                    'description' => ['required' => true]
                ];
                $validation = new Validation();
                $validation->validate($_POST, $rules);
                if($validation->hasError()){
                    $districts = District::all();
                    $errors = $validation->getErrorMessages();
                    return view('user\order_form', ['errors' => $errors,'districts' => $districts]);
                }

                // Calculate due date from from service type
                $due_date = $this->calculate_due_date($request->service_type);

                // Genereate product barcode
                $barcode = new \Com\Tecnick\Barcode\Barcode();
                $order_no = Random::generateId(16);
                try{
                    $qr_code = $barcode->getBarcodeObj('QRCODE,H',
                        $order_no,
                        200,
                        200,
                        'black',
                        array(0, 0, 0, 0));
                    $qr_code_image = $qr_code->getPngData();
                    $ds = DIRECTORY_SEPARATOR;
                    $target_path = BASE_PATH."{$ds}public{$ds}img{$ds}order_barcode{$ds}";
                    $timestamp = time();
                    $img_name = $order_no . $timestamp  . '.png';
                    file_put_contents($target_path . $img_name, $qr_code_image);
                    // Save to DB
                    $image_path = "img{$ds}order_barcode{$ds}" . $img_name;

                }catch (\Exception $e){
                    Session::add('error', 'QR code could not be generated');
                    Redirect::back();
                    exit();
                }

                //Add the user
                $details = [
                    'order_no' => $order_no,
                    'request_type' => $request->request_type,
                    'service_type' => $request->service_type,
                    'email' => $request->email,
                    'district_id' => $request->district,
                    'route_id' => $request->route,
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'parcel_name' => $request->parcel_name,
                    'parcel_size' => $request->parcel_size,
                    'parcel_quantity' => $request->parcel_quantity,
                    'pick_up_address' => $request->pick_up_address,
                    'pick_up_landmark' => $request->pick_up_landmark,
                    'delivery_address' => $request->delivery_address,
                    'delivery_landmark' => $request->delivery_landmark,
                    'description' => $request->description,
                    'rider_id' => '',
                    'order_status' => 'registered',
                    'due_date' => $due_date,
                    'barcode' => $image_path
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
                    'service_type' => ['required' => true],
                    'email' => ['required' => true, 'email' => true],
                    'district' => ['required' => true, 'maxLength' => 100, 'mixed' => true],
                    'route' => ['required' => true,'string' => true],
                    'fullname' => ['required' => true,'maxLength' => 50, ],
                    'address' => ['required' => true, 'maxLength' => 100],
                    'phone' => ['required' => true, 'maxLength' => '50'],
                    'parcel_name' => ['required' => true, 'maxLength' => '150'],
                    'parcel_size' => ['number' => true],
                    'parcel_quantity' => ['number' => true],
                    'pick_up_address' => ['mixed' => true],
                    'pick_up_landmark' => ['mixed' => true],
                    'delivery_address' => ['mixed' => true],
                    'delivery_landmark' => ['mixed' => true],
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
                    'district_id' => $request->district,
                    'service_type' => $request->service_type,
                    'email' => $request->email,
                    'route_id' => $request->route,
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
                    echo json_encode(['success' => 'Order updated successfully']);
                    exit();
                }catch (\Exception $e){
                    header('HTTP 1.1 500 Server Error', true, 500);
                    echo json_encode(['error' => 'Order updated failed ' . $e]);
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

    public function delete_order($id){
        $order_no = $id['order_no'];
        if(Request::has('post')){
            $request = Request::get('post');
            if(CSRFToken::verifyCSRFToken($request->token)){
                $order = Order::where('order_no', '=', $order_no)->first();
                $order->delete();
                Session::add('success', 'Order deleted successfully');
                Redirect::to('/orders');
            }

        }else{
            echo 'request error';
        }
    }

    private function calculate_due_date($service_type){
        $dt = Carbon::now();
        switch ($service_type){
            case 'same-day';
                if($dt->hour > 18){
                    $dt2 = Carbon::tomorrow()->addHours(8);
                    return $dt2;
                }else{
                    $dt->addHours(6);
                    return $dt;
                }
                break;
            case 'next-day':
                $dt->addHours(18);
                return $dt;
                break;
            case 'two-day':
                $dt->addDays(2);
                return $dt;
                break;
            case 'premium':
                if($dt->hour > 20){
                    $dt2 = Carbon::tomorrow();
                    return $dt2->addHours(6);
                }else{
                    $dt->addHours(5);
                    return $dt;
                }
                break;
            default:
                return Carbon::now()->addHours(24);
        }


    }

    public function pot(){
        $orders = Order::where('order_status', '!=', ['registered', 'completed', 'ongoing'])->orderBy('id','desc')->get();
        return view('user\pot', ['orders' => $orders]);
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


    public function search_orders($terms){
        //Get the value of the term from the array
        $term = trim($terms['terms']);
        $searchresult = Order::query()
            ->where('order_no', 'LIKE', "%{$term}%")
            ->orWhere('parcel_name', 'LIKE', "%{$term}%")
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