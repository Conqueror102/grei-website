@props(['property', 'modal' => true])
@php($p = $property)
<x-card :href="route('real-estate.show', $p)" :modal="$modal ? 'property-'.$p->id : null" :image="$p->cover" :title="$p->title"
    :right="$p->price ? $p->price_label : 'On request'" :sub="$p->location" :badge="$p->listing_label"
    :specs="array_values(array_filter([
        $p->area_sqm ? ['arrows-out-simple', number_format($p->area_sqm).' m²'] : null,
        ['buildings', $p->category_label],
        $p->bedrooms ? ['bed', $p->bedrooms.' '.\Illuminate\Support\Str::plural('bed', $p->bedrooms)] : null,
        $p->bathrooms ? ['bathtub', $p->bathrooms.' '.\Illuminate\Support\Str::plural('bath', $p->bathrooms)] : null,
    ]))" />
