@props(['stay'])
@php($s = $stay)
<x-card :href="route('stays.show', $s)" :image="$s->cover" :title="$s->title" :right="$s->rate_label.' / night'" :sub="$s->type.' · '.$s->location"
    :specs="[
        ['users', 'Up to '.$s->max_guests.' guests'],
        ['bed', $s->bedrooms.' '.\Illuminate\Support\Str::plural('bed', $s->bedrooms)],
        ['bathtub', $s->bathrooms.' '.\Illuminate\Support\Str::plural('bath', $s->bathrooms)],
        ['moon-stars', 'Min '.$s->min_nights.' '.\Illuminate\Support\Str::plural('night', $s->min_nights)],
    ]" />
