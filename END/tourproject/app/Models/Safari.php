<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Safari extends Model
{
    protected $fillable = [
        'title', 'highlights', 'description', 'price', 
        'duration', 'included', 'itinerary'
    ];

    public function images()
    {
        return $this->hasMany(SafariImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($safari) {
            foreach ($safari->images as $image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->storagePath());
            }
        });
    }
}
