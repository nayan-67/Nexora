<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $table = 'coupons';
    protected $fillable = [
        'coupon_code',
        'description',
        'valid_from',
        'valid_till',
        'type',
        'discount_value',
        'max_discount',
        'minimum_order',
        'usage_number',
        'usage_limit',
        'usage_per_user',
        'first_order_only',
        'status',
    ];
}
