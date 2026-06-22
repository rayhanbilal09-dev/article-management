<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'status',
        'published_at',
        'cover_image'
    ];

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function getAverageRatingAttribute(): float
    {
        return (float) round($this->ratings()->avg('rating') ?? 0, 1);
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Automatically generate slug if not provided and clean up files on deletion
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::updating(function ($model) {
            if (empty($model->slug) || $model->isDirty('title')) {
                $model->slug = Str::slug($model->title);
            }
        });

        static::deleting(function ($model) {
            // Delete cover image
            if ($model->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($model->cover_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($model->cover_image);
            }

            // Delete gallery media files
            foreach ($model->media as $media) {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($media->file_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($media->file_path);
                }
            }
        });
    }
}