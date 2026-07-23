<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table='address';
    protected $fillable = [
        'user_id',
        'f_name',
        'l_name',
        'phone',
        'address1',
        'address2',
        'city',
        'postcode',
        'country',
        'state',
        'is_default',
        'is_delete',
    ];
}
