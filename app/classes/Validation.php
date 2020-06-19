<?php


namespace App\Classes;

use Illuminate\Database\Capsule\Manager as Capsule;


class Validation{

    private static $error = [];

    private static $errorMessage = [
        'string' => 'The :attribute field is letters only',
        'required' => 'The :attribute field is required',
        'minLength' => 'The :attribute field must have a minimum of :policy characters',
        'maxLength' => 'The :attribute field must have a maximum of :policy characters',
        'mixed' => 'The :attribute field can contain letters, numbers and dash space only',
        'number' => 'The :attribute field can contain only numbers',
        'email' => 'The email address is not valid',
        'unique' => 'The :attribute is already taken',
        'confirmed' => 'The password do not match',
        'unique_edit' => ':attribute already exists',
        'ussd_string' => 'Invalid string'
    ];

    private static function setErrorMessages($error, $key = null){
        if($key){
            self::$error[$key][] = $error;
        }else{
            self::$error[] = $error;
        }
    }

    public function validate(array $data, array $policies){

        foreach ($data as $column => $value){
            if(in_array($column, array_keys($policies))){
                self::runValidation(['column' => $column, 'value' => $value, 'policies' => $policies[$column]]);

            }
        }

    }

    private static function runValidation(array $data){
        $column = $data['column'];
        foreach($data['policies'] as $rule => $policy){
            $valid = call_user_func_array([self::class, $rule], [$column, $data['value'], $policy]);
            if(!$valid){
                self::setErrorMessages(
                    str_replace([':attribute', ':policy', '_'],[$column, $policy, ' '], self::$errorMessage[$rule]), $column
                );
            }
        }
    }

    public function hasError(){
        return count(self::$error) > 0 ? true: false;
    }

    public function getErrorMessages(){
        return self::$error;
    }


    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     *
     */
    protected static function unique($column, $value, $policy){

        if($value != null && !empty(trim($value))){
            return !Capsule::table($policy)->where($column, '=', $value)->exists();
        }
        return true;
    }

    /**
     * @param $column
     * @param $value
     * @param $policy
     * @return bool
     */

    protected static function required($column, $value, $policy){

        return $value !== null && !empty(trim($value));

    }

    protected static function minLength($column, $value, $policy){
        if($value != null && !empty(trim($value))){
            return strlen($value) >= $policy;
        }

        return true;

    }

    protected static function maxLength($column, $value, $policy){
        if($value != null && !empty(trim($value))){
            return strlen($value) <= $policy;
        }

        return true;

    }

    protected static function email($column, $value, $policy){
        if($value != null && !empty(trim($value))){
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }

        return true;
    }

    public static function mixed($column, $value, $policy){
        if($value != null && !empty(trim($value))){
            if(!preg_match('/^[A-Za-z0-9 .,_~\-!@#\&%\^\'\*\(\)]+$/', $value)){
                return false;
            }
        }

        return true;
    }

    public static function string($column, $value, $policy){
        if($value != null && !empty(trim($value))){
            if(!preg_match('/^[A-Za-z ]+$/', $value)){
                return false;
            }
        }

        return true;
    }

    public static  function ussd_string($column, $value, $policy){
        if($value != null && !empty(trim($value))){
            if(!preg_match('/^[0-9 *]+$/', $value)) {
                // one or more of the 'special characters' found in $string
                return false;
            }
        }
        return true;
    }

    public static function number($column, $value, $policy){
        if($value != null && !empty(trim($value))){
            if(!preg_match('/^[0-9]+$/', $value)){
                return false;
            }
        }

        return true;
    }

    public static function confirmed($column, $value, $policy){
        if($value != null && !empty(trim($value))){
            return $policy === $value;
        }
        return true;
    }

    public static function unique_edit($column, $value, $policy){
        list($table, $id, $column_name) = explode('|', $policy);
        //echo 'table: '.$table . '<br>Id: '. $id .'<br>column_name: '. $column_name .'<br>column: '.$column .'<br> value: '.$value .'<br>';
        if($value != null && !empty(trim($value))){
            return !Capsule::table($table)->where($column, '=', $value)
                ->where($column_name, '!=', $id)
                ->exists();
        }
        return true;
    }


}