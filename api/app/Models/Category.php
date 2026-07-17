<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'order_number',
        'total_products',
        'image',
        'status',
    ];
}
