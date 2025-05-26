<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    // Automatically generate slug when creating or updating
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            $tag->slug = static::generateUniqueSlug($tag->name);
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name')) {
                $tag->slug = static::generateUniqueSlug($tag->name);
            }
        });
    }

    // Generate a unique slug
    protected static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check if slug exists and make it unique
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
