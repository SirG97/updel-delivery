<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class User extends Model{
    public $timestamps = true;
    protected $fillable = ['id', 'lastname', 'firstname', 'email', 'password',
                            'admin_right_id', 'job_description', 'job_title', 'image',
                            'online_status', 'phone'];
}