<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
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
        'gallery_images',
        'stock',
        'is_feature',
    ];

    protected $casts = [
        'features' => 'array',
        'gallery_images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id');
    }

    public function variant_attributes()
    {
        return $this->hasMany(VariantAttribute::class, 'product_id');
    }
}
