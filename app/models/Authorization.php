<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Authorization extends Model{
    public $timestamps = true;
    protected $primaryKey = 'user_id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id','auth_img'];
}