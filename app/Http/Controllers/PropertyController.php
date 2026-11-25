<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'category' => ['nullable', Rule::in(array_keys(Property::CATEGORIES))],
            'type' => ['nullable', Rule::in(array_keys(Property::LISTING_TYPES))],
            'city' => ['nullable', 'string', 'max:60'],
        ]);

        $properties = Property::ordered()
            ->when($filters['category'] ?? null, fn ($q, $v) => $q->where('category', $v))
            ->when($filters['type'] ?? null, fn ($q, $v) => $q->where('listing_type', $v))
            ->when($filters['city'] ?? null, fn ($q, $v) => $q->where('city', $v))
            ->get();

        return view('real-estate.index', [
            'properties' => $properties,
            'filters' => $filters,
            'cities' => Property::query()->distinct()->orderBy('city')->pluck('city'),
        ]);
    }

    public function show(Property $property)
    {
        return view('real-estate.show', [
            'property' => $property,
            'related' => Property::ordered()->whereKeyNot($property->id)->where('category', $property->category)->take(3)->get(),
        ]);
    }
}
