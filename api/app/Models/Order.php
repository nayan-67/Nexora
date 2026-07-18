<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'order_number',
        'order_status',
        'payment_status',
        'payment_mode',
        'billing_address_id',
        'shipping_address_id',
        'sub_total',
        'total_price',
        'eco_tax',
        'discount',
        'shipping',
    ];

    public function order()
    {
        return $this->hasMany(Order_product::class);
    }
}
