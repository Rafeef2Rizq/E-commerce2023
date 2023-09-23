<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['user_id','store_id','payment_method','status','payment_status'];
    public function store(){
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function user(){
        return $this->belongsTo(User::class)->withDefault(['name'=>'Gest Customer']);
    }
     public function products(){
        return   $this->belongsToMany(Product::class,'order_items','order_id','product_id','id','id')
        ->using(OrderItem::class)
        ->withPivot(['product_name','quantity','price','options']);
     }
     public function addresses(){
        return   $this->hasMany(OrderAddress::class);
     }
     public function billingAddress(){
        return  $this->hasOne(OrderItem::class,'order_id','id')
        ->where('type','=','billing');
     }
     public function shippingAddress(){
        return     $this->hasOne(OrderItem::class,'order_id','id')
        ->where('type','=','shipping');
     }
     public static function booted(){
        return static::creating(function (Order $order){
            $order->number = Order::generateNextOrderNumber();
        });
    }
    public static function generateNextOrderNumber()
    {
        // Get the current year
        $year = Carbon::now()->year;
    
        // Find the highest order number for the current year
        $maxNumber = Order::whereYear('created_at', $year)->max('number');
    
        // If there are no orders for the current year, start with 1
        if (!$maxNumber) {
            return $year . '0001';
        }
    
        // Extract the numeric part of the order number (e.g., '20230001' => 1)
        $numericPart = (int) substr($maxNumber, -4);
    
        // Increment the numeric part
        $numericPart++;
    
        // Format the numeric part with leading zeros
        $formattedNumericPart = str_pad($numericPart, 4, '0', STR_PAD_LEFT);
    
        // Combine the year and numeric part to create the new order number
        $newOrderNumber = $year . $formattedNumericPart;
    
        return $newOrderNumber;
    }
    
    
}
