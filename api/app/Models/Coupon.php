<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
    protected $fillable = [
        'name',
        'valid_from',
        'valid_till',
        'type',
        'amount',
        'uses_number',
        'status',
    ];
}
