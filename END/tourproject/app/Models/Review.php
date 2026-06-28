<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{
    protected $fillable = [
        'traveler_name', 'whatsapp_number', 'country', 'tour_id', 'safari_id',
        'title', 'rating', 'description', 'status',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function safari()
    {
        return $this->belongsTo(Safari::class);
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($review) {
            foreach ($review->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
        });
    }
}
