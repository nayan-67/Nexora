<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $table = 'variants';
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'is_sale',
        'sale_price',
        'stock',
        'attributes',
        'images',
        'featured_image',
        'gallery_image',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'attributes' => 'array',
        'gallery_image' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'is_sale' => 'boolean',
        'sale_price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
