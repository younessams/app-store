<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'order_item_size')->withPivot('quantity');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'order_item_color')->withPivot('quantity');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
