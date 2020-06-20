<?php


namespace App\Controllers;


use App\Classes\CSRFToken;
use App\Classes\Random;
use App\Classes\Redirect;
use App\Classes\Request;
use App\Classes\Session;
use App\Classes\Validation;
use App\Models\User;

class UserController extends BaseController {
     public function get_riders(){
        return view('user\riders', ['riders' => []]);
     }

     public function get_support_staff(){
         return view('user\support_staff', ['support_staffs' => []]);
     }

     public function get_managers(){
         $managers = User::all();
         return view('user\managers', ['managers' => $managers]);
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
                 if($validation->hasError()){
                     $errors = $validation->getErrorMessages();
                     return view('user\staff_form', ['errors' => $errors]);
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
                     'job_description' => $request->job_description
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

}