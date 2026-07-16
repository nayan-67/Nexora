<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table='wishlist';
    protected $fillable = [
        'u_id',
        'prd_id',
        'prd_type',
        'sku'
    ];
}