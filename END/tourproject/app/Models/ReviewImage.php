<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReviewImage extends Model
{
    protected $fillable = [
        'review_id', 'image_path',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->image_path);
    }

    public function storagePath(): string
    {
        return $this->image_path;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($image) {
            Storage::disk('public')->delete($image->image_path);
        });
    }
}
