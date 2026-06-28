<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'location',
        'category',
        'tags',
        'duration',
        'status',
        'author_id',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function images()
    {
        return $this->hasMany(BlogImage::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && !$blog->isDirty('slug')) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::deleting(function ($blog) {
            foreach ($blog->images as $image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->storagePath());
            }
        });
    }
}
