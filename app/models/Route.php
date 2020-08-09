<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model{
//    protected $primaryKey = 'route_id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['district_id','district','route_id', 'name', 'created_by'];

    public function district(){
        return $this->belongsTo(FoodCategory::class, 'district_id', 'route_id');
    }

    public function riders(){
        return $this->hasMany(Rider::class, 'route_id', 'user_id');
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