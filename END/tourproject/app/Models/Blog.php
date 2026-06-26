<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'description'];

    public function images()
    {
        return $this->hasMany(BlogImage::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($blog) {
            foreach ($blog->images as $image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->storagePath());
            }
        });
    }
}
