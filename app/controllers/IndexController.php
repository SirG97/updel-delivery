<?php

namespace App\Controllers;
use App\Classes\Mail;
use App\Classes\Redirect;

class IndexController extends BaseController{
    public function index(){
        return view('user\index');
    }

    public function about(){
        return view('user\about');
    }
}