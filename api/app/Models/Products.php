<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'type',
        'sku',
        'category_id',
        'sub_category_id',
        'description',
        'features',
        'price',
        'sale_price',
        'featured_image',
        'gallery_image',
        'stock',
        'is_feature',
        'is_delete',
    ];

    protected $casts = [
        'features' => 'array',
        'gallery_image' => 'array',
    ];

    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id');
    }

    public function variant_attributes()
    {
        return $this->hasMany(VariantAttribute::class, 'product_id');
    }
}
