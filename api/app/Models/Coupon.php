<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
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
