@php($p = $property)
<x-layouts.app :title="$p->title" :description="$p->summary">
    <section class="bg-white">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12 pt-8 md:pt-12 pb-16">
            <x-back-link :href="route('real-estate.index')">All properties</x-back-link>
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-[clamp(2.2rem,4vw,3.6rem)] font-normal leading-[1.05] tracking-[-0.035em]">{{ $p->title }}</h1>
                    <p class="inline-flex items-center gap-1.5 text-[13px] text-[#737373] mt-3"><i class="ph-duotone ph-map-pin text-[15px]"></i>{{ $p->location }} <span aria-hidden="true">·</span> {{ $p->listing_label }}</p>
                </div>
                <div class="text-[26px] font-medium tabular-nums">{{ $p->price_label }}</div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8 space-y-6">
                    <div class="aspect-[16/10] w-full overflow-hidden bg-[#EAEAEA]">
                        <x-img :src="$p->cover" :alt="$p->title" :w="1800" :eager="true" class="w-full h-full object-cover" />
                    </div>
                    <x-property-specs :property="$p" class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-4 border-y border-[#EFEFEF] text-[13px] text-[#525252] tabular-nums" />
                    <div class="space-y-4 text-[14px] leading-[1.7] text-[#525252] max-w-[720px]">
                        @foreach (preg_split("/\n\n+/", $p->description) as $para)<p>{{ $para }}</p>@endforeach
                    </div>
                    <div>
                        <h2 class="text-[15px] font-medium mb-4">Features</h2>
                        <ul class="grid sm:grid-cols-2 gap-x-6 gap-y-2.5 text-[13px] text-[#525252]">
                            @foreach ($p->features as $f)
                                <li class="flex items-start gap-2"><i class="ph-duotone ph-check text-[15px] text-[#111111] mt-0.5"></i>{{ $f }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @if (count($p->gallery) > 1)
                        <div class="grid grid-cols-2 gap-6">
                            @foreach (array_slice($p->gallery, 1, 4) as $img)
                                <div class="aspect-square overflow-hidden bg-[#EAEAEA]"><x-img :src="$img" :alt="$p->title" :w="900" class="w-full h-full object-cover" /></div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-6 bg-white border border-[#EAEAEA] p-6 sm:p-8">
                        <h2 class="text-[22px] font-normal tracking-[-0.02em]">Schedule a private viewing</h2>
                        <div class="mt-5">
                            <x-consult-form type="property" :subject-id="$p->id" :topic="'Viewing: '.$p->title" :cancel="false" submit="Request Viewing"
                                :message="'Interested in a private viewing of '.$p->title.'.'" message-label="Viewing Preferences" />
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="bg-[#F5F5F5] pt-20 pb-20">
            <div class="max-w-[1320px] mx-auto px-6 md:px-12">
                <x-split-head title="Similar<br>opportunities">Other {{ strtolower($p->category_label) }} properties our consultants recommend.</x-split-head>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($related as $r)<x-property-card :property="$r" :modal="false" />@endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
