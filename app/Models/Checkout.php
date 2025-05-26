<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = [
        'user_id',
        'guest_token',
        'full_name',
        'phone_number',
        'delivery_address',
    ];
    
}
