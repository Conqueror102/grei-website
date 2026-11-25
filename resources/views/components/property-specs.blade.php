@props(['property'])
@php($p = $property)
<div {{ $attributes }}>
    @if ($p->area_sqm)<div class="flex items-center gap-2"><i class="ph-duotone ph-arrows-out-simple text-[14px] text-[#8C8C8C]"></i><span>{{ number_format($p->area_sqm) }} m²</span></div>@endif
    <div class="flex items-center gap-2"><i class="ph-duotone ph-buildings text-[14px] text-[#8C8C8C]"></i><span>{{ $p->category_label }}</span></div>
    @if ($p->bedrooms)<div class="flex items-center gap-2"><i class="ph-duotone ph-bed text-[14px] text-[#8C8C8C]"></i><span>{{ $p->bedrooms }} {{ \Illuminate\Support\Str::plural('bed', $p->bedrooms) }}</span></div>@endif
    @if ($p->bathrooms)<div class="flex items-center gap-2"><i class="ph-duotone ph-bathtub text-[14px] text-[#8C8C8C]"></i><span>{{ $p->bathrooms }} {{ \Illuminate\Support\Str::plural('bath', $p->bathrooms) }}</span></div>@endif
</div>
