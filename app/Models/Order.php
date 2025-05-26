<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'uuid',
        'guest_token',
        'full_name',
        'phone_number',
        'delivery_address',
        'total_price',
        'status',
        'notes'
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->uuid = Str::uuid()->toString();
        });
    }

    // Define relationships if needed, like OrderItems or others
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
