<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_category';
    protected $fillable = [
        'name',
        'slug',
        'order_number',
        'category_id',
        'status',
        'is_delete',
    ];
}
