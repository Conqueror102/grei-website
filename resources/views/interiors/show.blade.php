@php($pr = $project)
<x-layouts.app :title="$pr->title" :description="$pr->summary">
    <section class="bg-white">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12 pt-8 md:pt-12 pb-16">
            <x-back-link :href="route('interiors.index').'#portfolio'">All projects</x-back-link>
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 md:gap-12 mb-10">
                <h1 class="text-[clamp(2.2rem,4vw,3.6rem)] font-normal leading-[1.05] tracking-[-0.035em] max-w-[640px]">{{ $pr->title }}</h1>
                <p class="text-[14px] leading-[1.58] text-[#6E6E6E] max-w-[295px] md:pt-2">{{ $pr->summary }}</p>
            </div>
            <div class="aspect-[16/8] w-full overflow-hidden bg-[#EAEAEA]">
                <x-img :src="$pr->cover" :alt="$pr->title" :w="2000" :eager="true" class="w-full h-full object-cover" />
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-4 border-b border-[#EFEFEF] text-[13px] text-[#525252]">
                <div class="flex items-center gap-2"><i class="ph-duotone ph-squares-four text-[14px] text-[#8C8C8C]"></i>{{ $pr->sector_label }}</div>
                <div class="flex items-center gap-2"><i class="ph-duotone ph-map-pin text-[14px] text-[#8C8C8C]"></i>{{ $pr->location }}</div>
                <div class="flex items-center gap-2"><i class="ph-duotone ph-calendar-blank text-[14px] text-[#8C8C8C]"></i>Completed {{ $pr->year }}</div>
                @if ($pr->area_sqm)<div class="flex items-center gap-2"><i class="ph-duotone ph-arrows-out-simple text-[14px] text-[#8C8C8C]"></i>{{ number_format($pr->area_sqm) }} m²</div>@endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mt-12">
                <div class="lg:col-span-4">
                    <h2 class="text-[15px] font-medium">Scope</h2>
                    <ul class="mt-4 flex flex-wrap gap-2">
                        @foreach ($pr->scope as $s)<li class="border border-[#E6E6E6] px-3 py-1.5 text-[12px] text-[#525252] rounded-[2px]">{{ $s }}</li>@endforeach
                    </ul>
                </div>
                <div class="lg:col-span-8 space-y-8">
                    @foreach (['The brief' => $pr->brief, 'Our approach' => $pr->approach, 'The outcome' => $pr->outcome] as $h => $t)
                        <div>
                            <h2 class="text-[22px] font-normal tracking-[-0.02em]">{{ $h }}</h2>
                            <p class="mt-3 text-[14px] leading-[1.7] text-[#525252]">{{ $t }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            @if (count($pr->gallery) > 1)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-14">
                    @foreach (array_slice($pr->gallery, 1) as $img)
                        <div class="aspect-square overflow-hidden bg-[#EAEAEA]"><x-img :src="$img" :alt="$pr->title" :w="900" class="w-full h-full object-cover" /></div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <x-feature title="Have a space<br>in mind?" :image="$next?->cover ?? config('grei.images.approach')" button="Free consult" modal="modal-consult" pad="pt-20 pb-20 md:pb-28">
        Tell us about it and we'll arrange a design consultation. @if($next) Next project: {{ $next->title }}. @endif
    </x-feature>
</x-layouts.app>
