<?php

namespace App\Models;

use App\Services\MediaStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'company_address',
        'image',
        'short_description',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return app(MediaStorage::class)->url($this->image);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

