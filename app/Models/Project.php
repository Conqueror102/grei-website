<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'scope' => 'array',
        'gallery' => 'array',
        'featured' => 'boolean',
    ];

    public const SECTORS = ['residential' => 'Residential', 'commercial' => 'Commercial', 'hospitality' => 'Hospitality'];

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderByDesc('featured')->orderBy('sort');
    }

    public function getCoverAttribute(): ?string
    {
        return $this->gallery[0] ?? null;
    }

    public function getSectorLabelAttribute(): string
    {
        return self::SECTORS[$this->sector] ?? ucfirst($this->sector);
    }
}
