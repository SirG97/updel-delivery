<?php


namespace App\classes;


class Menu{
    public static function is_active($menuItem){
        $uri = $_SERVER['REQUEST_URI'];
        if($uri === $menuItem){
            return 'selected';
        }
        return '';
    }
}