<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'product_type',
        'sku',
        'quantity',
        'price',
        'delivery_date',
        'rr_date',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
