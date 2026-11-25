<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'amenities' => 'array',
        'gallery' => 'array',
        'featured' => 'boolean',
    ];

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderByDesc('featured')->orderBy('sort');
    }

    public function getCoverAttribute(): ?string
    {
        return $this->gallery[0] ?? null;
    }

    public function getRateLabelAttribute(): string
    {
        return config('grei.currency.symbol').number_format($this->nightly_rate);
    }
}
