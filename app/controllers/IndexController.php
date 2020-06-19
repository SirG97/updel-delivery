<?php

namespace App\Controllers;
use App\Classes\Mail;
use App\Classes\Redirect;

class IndexController extends BaseController{
    public function show(){
        return view('user\login');

    }
}