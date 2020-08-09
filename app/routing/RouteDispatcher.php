<?php

namespace App;

use Altorouter;


class RouteDispatcher{
    protected $match;
    protected $controller;
    protected $method;

    function __construct(AltoRouter $router){
        $this->match = $router->match();
        if($this->match){
            list($this->controller, $this->method) = explode('@', $this->match['target']);
            // Check whether this controller and method are callable functions
             if(is_callable(array(new $this->controller, $this->method))){
                 call_user_func_array(array(new $this->controller, $this->method), array($this->match['params']));
             }else{
                 echo 'The method  is not defined in this controller`';
             }
        }else{
            header($_SERVER['SERVER_PROTOCOL']. '404 not found');
            view('errors.404');
        }
    }
}