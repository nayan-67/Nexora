<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
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
        'tax',
        'discount_value',
        'used_coupon',
        'shipping_fee',
    ];

    protected $casts = [
        'sub_total' => 'decimal:2',
        'total_price' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
    ];

    public function order()
    {
        return $this->hasMany(OrderItems::class);
    }
}
