<?php

namespace App\Controllers;

class BaseController{
    public function access_denied(){
        return view('user\accessdenied');
    }
}