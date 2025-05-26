<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Offer extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'discount_type', 'discount_value', 'start_date', 'end_date', 'image_url', 'is_active'];

    protected $appends = ['image_url_path'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($offer) {
            $offer->slug = Str::slug($offer->title);
        });

        static::updating(function ($offer) {
            if ($offer->isDirty('title')) {
                $offer->slug = Str::slug($offer->title);
            }
        });
    }


    /**
     * Get the URL for the offer image
     *
     * @return string
     */
    public function getImageUrlPathAttribute()
    {
        if (!$this->image_url) {
            return null;
        }

        // If the path already contains the full url or starts with http
        if (filter_var($this->image_url, FILTER_VALIDATE_URL) || str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }

        // If it starts with storage/ (assuming it was stored using the public disk)
        if (str_starts_with($this->image_url, 'storage/')) {
            return asset($this->image_url);
        }

        // Otherwise assume it's a relative path in the storage/app/public directory
        return asset('storage/' . $this->image_url);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
