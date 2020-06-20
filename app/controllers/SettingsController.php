<?php


namespace App\Controllers;


use App\Classes\Redirect;

class SettingsController extends BaseController{
    public function __construct()
    {
        if(!isAuthenticated()){
            Redirect::to('/login');
        }
    }
    public function showSettings(){
        return view('user\settings');
    }

    public function settings(){

    }
}