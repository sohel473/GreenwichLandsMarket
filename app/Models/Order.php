<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ordered', 'paymentId', 'orderId'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(Cart::class, 'order_cart');
    }

    public function getTotalAttribute()
    {
        return $this->orderItems->sum(function (Cart $cart) {
            return $cart->total;
        });
    }
}
