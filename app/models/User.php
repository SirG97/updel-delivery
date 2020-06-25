<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class User extends Model{
    public $timestamps = true;
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    protected $fillable = ['user_id','username', 'lastname', 'firstname', 'email', 'password',
                            'admin_right', 'job_description', 'job_title', 'image','city', 'state', 'address',
                            'online_status', 'phone'];
}