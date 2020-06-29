<?php


namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model{
    public $timestamps = true;
//    protected $primaryKey = 'user_id';
    protected $dates = ['deleted_at'];
    protected $fillable = ['rider_id','user_id','route_id'];

    public function routes(){
        return $this->hasMany(Route::class, 'route_id', 'route_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function transform($data){
        $routes = [];
        foreach ($data as $item){
            array_push($routes,[
                'district_id' => $item->district_id,
                'district' => $item->district,
                'route_id' => $item->route_id,
                'name' => $item->name,
                'created_by' => $item->created_by,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ]);
        }
        return $routes;
    }
}