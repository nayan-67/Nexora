<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'u_id',
        'prd_id',
        'prd_type',
        'sku',
        'quantity',
    ];
}
