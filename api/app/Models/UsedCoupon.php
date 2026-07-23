<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsedCoupon extends Model
{
    protected $table = 'used_coupon';
    protected $fillable = [
        'user_id',
        'order_number',
        'coupon_name',
        'amount_type',
        'amount',
    ];
}
