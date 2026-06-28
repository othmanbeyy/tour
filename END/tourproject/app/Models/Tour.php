<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tour extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'price', 'duration', 'itinerary', 'included', 'excluded',
        'seo_meta_title', 'seo_meta_description', 'focus_keyword',
    ];

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tour) {
            if (empty($tour->slug)) {
                $tour->slug = Str::slug($tour->title);
            }
        });

        static::updating(function ($tour) {
            if ($tour->isDirty('title') && !$tour->isDirty('slug')) {
                $tour->slug = Str::slug($tour->title);
            }
        });

        static::deleting(function ($tour) {
            foreach ($tour->images as $image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->storagePath());
            }
        });
    }
}
