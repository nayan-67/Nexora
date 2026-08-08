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
        'request_date',
        'rr_date',
        'refund_date',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'delivery_date' => 'datetime',
        'request_date' => 'datetime',
        'rr_date' => 'datetime',
        'refund_date' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
