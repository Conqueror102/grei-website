<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'features' => 'array',
        'gallery' => 'array',
        'featured' => 'boolean',
    ];

    public const CATEGORIES = ['residential' => 'Residential', 'commercial' => 'Commercial', 'land' => 'Land'];
    public const LISTING_TYPES = ['sale' => 'For sale', 'let' => 'To let', 'investment' => 'Investment'];

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderByDesc('featured')->orderBy('sort');
    }

    public function getCoverAttribute(): ?string
    {
        return $this->gallery[0] ?? null;
    }

    public function getPriceLabelAttribute(): string
    {
        if (! $this->price) {
            return 'Price on application';
        }

        return config('grei.currency.symbol').number_format($this->price).($this->price_suffix ? ' '.$this->price_suffix : '');
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    public function getListingLabelAttribute(): string
    {
        return self::LISTING_TYPES[$this->listing_type] ?? ucfirst($this->listing_type);
    }
}
