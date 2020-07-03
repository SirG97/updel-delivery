<?php


namespace App\Controllers;


use App\Classes\CSRFToken;
use App\Classes\Random;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Resize;
use App\Classes\Session;
use App\Classes\Validation;
use App\Classes\Upload;
use App\Models\User;

class UserController extends BaseController {
     public function get_riders(){
         $riders = User::where('admin_right','Rider')->orderBy('id','desc')->get();

        return view('user\riders', ['staffs' => $riders]);
     }

     public function get_support_staff(){
         $support_staff = User::where('admin_right','Customer Service Adviser')->orderBy('id','desc')->get();
         return view('user\support_staff', ['staffs' => $support_staff]);
     }

     public function get_managers(){
         $managers = User::where('admin_right','Manager')->orderBy('id','desc')->get();
         return view('user\managers', ['staffs' => $managers]);
     }

     public function get_staff($id){
         $id = $id['staff_id'];
         $profile = User::where('user_id', $id)->first();
         //dd($profile);
         return view('user\staff', ['profile' => $profile]);
     }

     public function new_staff_form(){
         return view('user\staff_form');
     }

     public function store_staff(){
         if(Request::has('post')){
             $request = Request::get('post');
             if(CSRFToken::verifyCSRFToken($request->token)){
                 $rules = [
                     'email' => ['required' => true, 'maxLength' => 30, 'email' => true, 'unique' =>'users'],
                     'username' => ['required' => true, 'maxLength' => 40, 'string' => true, 'unique' => 'users'],
                     'firstname' => ['required' => true, 'maxLength' => 40, 'string' => true],
                     'lastname' => ['string' => true, 'maxLength' => 40],
                     'phone' => ['required' => true,'maxLength' => 14, 'minLength' => 11, 'number' => true, 'unique' => 'users'],
                     'city' => ['required' => true, 'maxLength' => '50', 'string' => true],
                     'state' => ['required' => true, 'maxLength' => '50', 'string' => true],
                     'address' => ['required' => true, 'maxLength' => '150'],
                     'password' => ['required' => true,  'minLength' => 5],
                     'admin_right' => ['required' => true, 'maxLength' => 50],
                     'job_title' => ['required' => true, 'maxLength' => 100],
                     'job_description' => ['required' => true,  'maxLength' => 150]
                 ];
                 $validation = new Validation();
                 $validation->validate($_POST, $rules);

                 // File validation in case it exists
                 $file = Request::get('file');
//                 dd($file);
                 $filename = isset($file->profile_pics->name) ? $filename = $file->profile_pics->name: $filename = '';
                 $file_error = [];
                 if(empty($filename)){
                     $file_error['profile_pics'] = ['upload an image'];
                 }elseif (!Upload::is_image($filename)){
                     $file_error['profile_pics'] = ['Image is not a valid image'];
                 }
                 if($validation->hasError()){
                     $input_errors = $validation->getErrorMessages();
                     count($file_error) ? $errors = array_merge($input_errors, $file_error) : $errors = $input_errors;
                     return view('user\staff_form', ['errors' => $errors]);
                 }

                 // Deal with the upload first
                 $ds = DIRECTORY_SEPARATOR;
                 // Resize the image
                 $temp_file = $file->profile_pics->tmp_name;

                 $image_path = Upload::move($temp_file, "img{$ds}uploads{$ds}profile", $filename)->path();
                 if($image_path !== ''){
                     $resize = new Resize();
                     $resize->squareImage($image_path, $image_path, 128);
                 }

                 //Add the user
                 $details = [
                     'user_id' => Random::generateId(16),
                     'username' => $request->username,
                     'lastname' => $request->lastname,
                     'firstname' => $request->firstname,
                     'email' => $request->email,
                     'phone' => $request->phone,
                     'address' => $request->address,
                     'city' => $request->city,
                     'state' => $request->state,
                     'password' => password_hash($request->password, PASSWORD_BCRYPT),
                     'admin_right' => $request->admin_right,
                     'job_title' => $request->job_title,
                     'job_description' => $request->job_description,
                     'image' => $image_path
                 ];

                 User::create($details);
                 Request::refresh();
                 Session::add('success', 'New user created successfully');

                 Redirect::to('/staff');
                 exit();

             }
             Redirect::to('/staff');
         }

     }

     public function edit_staff($id){
         $user_id = $id['user_id'];
//            dd(Request::all());
         if(Request::has('post')){
             $request = Request::get('post');

             if(CSRFToken::verifyCSRFToken($request->token, false)){
                 $rules = [
                     'email' => ['required' => true, 'maxLength' => 30, 'email' => true, 'unique_edit' => 'users|' .$user_id .'|user_id'],
                     'username' => ['required' => true, 'maxLength' => 40, 'string' => true, 'unique_edit' => 'users|' .$user_id .'|user_id'],
                     'firstname' => ['required' => true, 'maxLength' => 40, 'string' => true],
                     'lastname' => ['string' => true, 'maxLength' => 40],
                     'phone' => ['required' => true,'maxLength' => 14,  'number' => true, 'unique_edit' => 'users|' .$user_id .'|user_id'],
                     'city' => ['required' => true, 'maxLength' => '50', 'string' => true],
                     'state' => ['required' => true, 'maxLength' => '50', 'string' => true],
                     'address' => ['required' => true, 'maxLength' => '150'],
                     'password' => ['minLength' => 5],
                     'admin_right' => ['required' => true, 'maxLength' => 50],
                     'job_title' => ['required' => true, 'maxLength' => 100],
                     'job_description' => ['required' => true,  'maxLength' => 150]
                 ];

                 $validation = new Validation();
                 $validation->validate($_POST, $rules);
                 //Handle file upload
                 $file = Request::get('file');
                 $filename = isset($file->profile_pics->name) ? $filename = $file->profile_pics->name: $filename = '';
                 $file_error = [];
                 if(isset($file->profile_pics->name) && !Upload::is_image($filename)){
                     $file_error['profile_pics'] = ['Image is not a valid image'];
                 }
                 if($validation->hasError()){
                     $errors = $validation->getErrorMessages();
                     header('HTTP 1.1 422 Unprocessable Entity', true, 422);
                     echo json_encode($errors);
                     exit();
                 }

                 $user = User::findOrFail($user_id);

                 //Add the order details to an array
                 //Add the user
                     $user->username = $request->username;
                     $user->lastname = $request->lastname;
                     $user->firstname = $request->firstname;
                     $user->email = $request->email;
                     $user->phone = $request->phone;
                     $user->address = $request->address;
                     $user->city = $request->city;
                     $user->state = $request->state;
                     $user->admin_right = $request->admin_right;
                     $user->job_title = $request->job_title;
                     $user->job_description = $request->job_description;

                 if($request->password !== ''){
                     $user->password = password_hash($request->password, PASSWORD_BCRYPT);
                 }

                 // Deal with the upload first
                 if($filename){
                     $ds = DIRECTORY_SEPARATOR;
                     //get the old image for deletion
                     $old_image = BASE_PATH ."{$ds}public{$ds}$user->image";
                     $temp_file = $file->profile_pics->tmp_name;
                     $image_path = Upload::move($temp_file, "img{$ds}uploads{$ds}profile", $filename)->path();
                     if($image_path !== ''){
                         $resize = new Resize();
                         $resize->squareImage($image_path, $image_path, 128);
                     }
                     unlink($old_image);
                     $user->image = $image_path;
                 }

                 try{
                     $user->save();
                     echo json_encode(['success' => 'Staff updated successfully']);
                     exit();
                 }catch (\Exception $e){
                     header('HTTP 1.1 500 Server Error', true, 500);
                     echo json_encode(['error' => 'Staff updated failed ']);
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

     public function delete_staff($id){
         $user_id = $id['user_id'];
         if(Request::has('post')){
             $request = Request::get('post');
             if(CSRFToken::verifyCSRFToken($request->token)){
                 try{
                     $staff = User::where('user_id', '=', $user_id)->first();
                     $staff->delete();
                     Session::add('success', 'Staff deleted successfully');

                     Redirect::back();
                 }catch (\Exception $e){
                     Session::add('error', 'Staff deletion failed');
                     Redirect::back();
                 }

             }
         }else{
             Session::add('error', 'Staff deletion failed');
             Redirect::back();
         }
     }

     public function view_profile(){
         $id = Session::get('SESSION_USER_ID');
         $profile = User::where('user_id', $id)->first();
         //dd($profile);
         return view('user\profile', ['profile' => $profile]);
     }

}