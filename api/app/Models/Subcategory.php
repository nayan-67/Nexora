<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;
    protected $table = 'sub_category';
    protected $fillable = [
        'name',
        'slug',
        'order_number',
        'category_id',
        'status',
    ];
}
