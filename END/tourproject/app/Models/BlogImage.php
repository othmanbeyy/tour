<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BlogImage extends Model
{
    protected $fillable = ['blog_id', 'image_path'];
    protected $appends = ['url'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->storagePath());
    }

    public function storagePath()
    {
        return ltrim(preg_replace('#^/?storage/#', '', $this->image_path), '/');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($image) {
            Storage::disk('public')->delete($image->storagePath());
        });
    }
}
