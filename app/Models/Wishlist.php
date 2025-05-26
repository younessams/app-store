<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'guest_token',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
