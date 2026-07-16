<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantAttribute extends Model
{
    protected $table = 'variant_attributes';
    protected $fillable = [
        'product_id',
        'attribute_name',
        'attribute_values',
        'display_type',
    ];

    protected $casts = [
        'attribute_values' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
