<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = [
        'user_id',
        'addr_name',
        'first_name',
        'last_name',
        'phone',
        'address1',
        'address2',
        'city',
        'postcode',
        'country',
        'state',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'postcode' => 'numeric',
        'phone' => 'numeric'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
