<?php

namespace App\Controllers;

use Firebase\JWT\JWT;

class BaseController{
    public function access_denied(){
        return view('user\accessdenied');
    }


}