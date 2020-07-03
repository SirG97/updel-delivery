<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;



class Order extends Model{
    use SoftDeletes;

    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['district_id','route_id','email', 'service_type','due_date', 'order_no', 'fullname', 'address', 'phone', 'parcel_name',
                            'parcel_quantity', 'parcel_size', 'pick_up_address', 'pick_up_landmark',
                            'delivery_address', 'delivery_landmark', 'description', 'request_type',
                            'rider_id', 'order_status', 'barcode'];

    public function rider(){
        return $this->hasOneThrough(User::class, Rider::class, 'user_id', 'rider_id', 'user_id', 'rider_id');
    }


    public function route(){
        return $this->hasOne(Route::class, 'route_id', 'route_id');
    }


    public function transform($data){
        $orders = [];
        foreach ($data as $item){
            array_push($orders,[
                'status' => $item->status,
                'customer_id' => $item->customer_id,
                'surname' => $item->surname,
                'firstname' => $item->firstname,
                'email' => $item->email,
                'phone' => $item->phone,
                'address' => $item->address,
                'city' => $item->city,
                'state' => $item->state,
                'amount' => $item->amount,
            ]);
        }
        return $orders;
    }
} 