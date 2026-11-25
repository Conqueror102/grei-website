@props(['property'])
@php($p = $property)
{{-- Zenith PropertyDetailModal --}}
<x-modal id="property-{{ $p->id }}" :title="e($p->title)" max="max-w-2xl">
    <div class="space-y-6">
        <div class="aspect-[16/10] w-full overflow-hidden bg-[#EAEAEA]">
            <x-img :src="$p->cover" :alt="$p->title" :w="1400" class="w-full h-full object-cover" />
        </div>
        <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-2">
            <div>
                <h4 class="text-[22px] font-normal text-[#111111] tracking-[-0.02em]">{{ $p->title }}</h4>
                <p class="inline-flex items-center gap-1.5 text-[12px] text-[#737373] mt-1">
                    <i class="ph-duotone ph-map-pin text-[14px]"></i>
                    <span>{{ $p->location }}</span><span aria-hidden="true">·</span><span>{{ $p->listing_label }}</span>
                </p>
            </div>
            <div class="text-[22px] font-medium text-[#111111] tabular-nums">{{ $p->price_label }}</div>
        </div>
        <x-property-specs :property="$p" class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-4 border-y border-[#EFEFEF] text-[12px] text-[#525252] tabular-nums" />
        <div class="space-y-3 text-[13px] leading-[1.65] text-[#525252]">
            <p>{{ $p->summary }}</p>
            <p class="text-[#737373]">{{ \Illuminate\Support\Str::before($p->description, "\n") }}</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <button type="button" data-open-modal="viewing-{{ $p->id }}" class="flex-1 inline-flex items-center justify-center gap-2 bg-[#111111] hover:bg-[#262626] text-white text-[12px] font-medium tracking-[0.04em] uppercase px-6 py-3.5 rounded-[2px] transition-colors cursor-pointer">
                <i class="ph-duotone ph-calendar-blank text-[14px]"></i><span>Schedule Private Viewing</span>
            </button>
            <a href="{{ route('real-estate.show', $p) }}" class="inline-flex items-center justify-center gap-2 border border-[#E0E0E0] bg-white hover:bg-[#FAFAFA] text-[#111111] text-[12px] font-medium px-5 py-3.5 rounded-[2px] transition-colors cursor-pointer">
                <i class="ph-duotone ph-arrows-out-simple text-[14px]"></i><span>Full Details</span>
            </a>
        </div>
    </div>
</x-modal>
<x-modal id="viewing-{{ $p->id }}" :title="'Schedule a Private Viewing'" max="max-w-lg">
    <x-consult-form type="property" :subject-id="$p->id" :topic="'Viewing: '.$p->title"
        :intro="'Arrange a private viewing of '.$p->title.'. An advisor will confirm a time and send the full information pack.'"
        :message="'Interested in a private viewing of '.$p->title.'.'" message-label="Viewing Preferences" />
</x-modal>
