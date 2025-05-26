<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'category_id',
        'brand',
        'weight',
        'gender',
        'description',
        'stock',
        'price',
        'discount',
        'tag_number',
        'tax',
    ];

    protected $dates = ['deleted_at']; // Add deleted_at field

    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) { // Only generate slug if not manually set
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    /**
     * Generate a unique slug.
     */
    protected static function generateUniqueSlug($name, $productId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->where('id', '!=', $productId)->exists()) {
            $slug = "{$originalSlug}-" . $count++;
        }

        return $slug;
    }

    /**
     * Relationships =============================================
     */

    // Sizes Relationship
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_size');
    }

    // Colors Relationship
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }

    // Tags Relationship
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->HasMany(ProductImage::class, 'product_id');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
