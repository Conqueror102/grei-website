@props(['project'])
@php($pr = $project)
<x-card :href="route('interiors.show', $pr)" :image="$pr->cover" :title="$pr->title" :right="(string) $pr->year" :sub="$pr->location" :badge="$pr->sector_label"
    :specs="array_values(array_filter([
        $pr->area_sqm ? ['arrows-out-simple', number_format($pr->area_sqm).' m²'] : null,
        ['paint-brush-household', $pr->scope[0] ?? 'Interior design'],
        ['stack', count($pr->scope).' services'],
    ]))" />
