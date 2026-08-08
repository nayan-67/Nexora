<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $table = "order_address";
    protected $fillable = [
        'user_id',
        'order_number',
        'type',
        'first_name',
        'last_name',
        'phone',
        'address1',
        'address2',
        'city',
        'postcode',
        'country',
        'state',
    ];
}
