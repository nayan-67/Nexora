<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table='wishlist';
    protected $fillable = [
        'user_id',
        'prd_id',
        'prd_type',
        'sku'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}