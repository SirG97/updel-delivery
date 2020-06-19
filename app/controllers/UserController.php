<?php


namespace App\Controllers;


class UserController extends BaseController {
     public function get_riders(){
        return view('user\riders', ['riders' => []]);
     }

     public function get_support_staff(){
         return view('user\support_staff', ['support_staffs' => []]);
     }

     public function get_managers(){
         return view('user\managers', ['managers' => []]);
     }

     public function new_staff_form(){
         return view('user\staff_form');
     }

     public function store_staff(){

     }

}