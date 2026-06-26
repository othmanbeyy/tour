<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'title', 'description', 'price', 'duration', 'itinerary'
    ];

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($tour) {
            foreach ($tour->images as $image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->storagePath());
            }
        });
    }
}
