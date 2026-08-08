<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'category';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'total_products',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
}
