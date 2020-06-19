<?php


namespace App\Classes;


class Session{
    public static function add($name, $value){
        if($name != '' && !empty($name) && $value != '' && !empty($value)){
            return $_SESSION[$name] = $value;
        }
        throw new \Exception('Name and value is required');
    }

    public static function get($name){
        return $_SESSION[$name];
    }

    public static function has($name){
        if($name != '' && !empty($name)){
            return (isset($_SESSION[$name])) ? true : false;
        }
        throw new \Exception('Name is required');
    }

    public static function remove($name){
        if(self::has($name)){
            unset($_SESSION[$name]);

        }
    }

    public static function flash($name, $value = ''){
        if(self::has($name)){
            $oldvalue = self::get($name);
            self::remove($name);

            return $oldvalue;
        }else{
            self::add($name, $value);
        }

        return null;
    }
}