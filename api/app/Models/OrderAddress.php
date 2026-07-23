<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $table = "order_address";
    protected $fillable = [
        'user_id',
        'order_no',
        'type',
        'f_name',
        'l_name',
        'phone',
        'address1',
        'address2',
        'city',
        'postcode',
        'country',
        'state',
    ];
}
