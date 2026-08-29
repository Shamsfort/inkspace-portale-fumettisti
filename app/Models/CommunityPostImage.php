<?php

namespace App\Models;

use App\Services\MediaStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityPostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_post_id',
        'path',
        'position',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(CommunityPost::class, 'community_post_id');
    }

    public function getUrlAttribute(): ?string
    {
        return app(MediaStorage::class)->url($this->path);
    }
}

