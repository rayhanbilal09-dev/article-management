<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    protected $fillable = [
        'article_id',
        'type',
        'file_path',
        'caption',
        'order',
        'created_by'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
