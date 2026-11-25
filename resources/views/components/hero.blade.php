@props([
    'title', 'text' => null, 'cta' => null, 'modal' => null, 'href' => null, 'image' => null, 'alt' => '',
    'eyebrow' => null, 'icon' => 'sparkle', 'chips' => [], 'card' => [], 'framed' => false, 'slides' => [], 'overlayId' => null,
])
{{-- Zenith Hero: editorial split + architectural stage.
     Every page uses this one hero so they stay consistent:
     glass label, word-by-word headline, quick-fact chips, and a large photo with a floating glass card. --}}
<section id="top" class="bg-white relative overflow-hidden">
    <div class="max-w-[1320px] mx-auto px-6 md:px-12 pt-8 md:pt-12 pb-6 relative z-20">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 md:gap-12">
            <div>
                @if ($eyebrow)
                    <span class="hero-label"><i class="ph-duotone ph-{{ $icon }}"></i>{{ $eyebrow }}</span>
                @endif
                <h1 class="{{ $eyebrow ? 'mt-5' : '' }} text-[clamp(2.45rem,4.7vw,4.35rem)] font-normal leading-[1.03] tracking-[-0.035em] text-[#111111] max-w-[720px]">{!! $title !!}</h1>
                @if ($cta)
                    <div class="mt-7 md:mt-8">
                        <a href="{{ $href ?? '#' }}" @if($modal) data-open-modal="{{ $modal }}" @endif class="zr-btn-hero focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#111111]">{{ $cta }}</a>
                    </div>
                @endif
            </div>
            @if ($text || count($chips))
                <div class="max-w-[320px] md:pt-2">
                    @if ($text)
                        <p class="text-[14px] leading-[1.58] text-[#6E6E6E]">{{ $text }}</p>
                    @endif
                    @if (count($chips))
                        <ul class="mt-5 flex flex-wrap gap-2">
                            @foreach ($chips as [$chipIcon, $chip])
                                <li class="hero-chip"><i class="ph-duotone ph-{{ $chipIcon }}"></i>{{ $chip }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @if (count($slides))
        <div class="relative w-full max-w-[1440px] mx-auto mt-4 md:mt-6 select-none">
            <x-hero-carousel :slides="$slides" />
        </div>
    @elseif ($image)
        @if ($framed)
            <div @if($overlayId) id="{{ $overlayId }}" @endif class="max-w-[1320px] mx-auto px-6 md:px-12 pb-10 md:pb-14 relative scroll-mt-24">
                <div class="hero-frame relative overflow-hidden rounded-[4px] bg-[#EAEAEA]">
                    <x-img :src="$image" :alt="$alt" :eager="true" :w="2000" class="w-full h-full object-cover block hero-drift" />
                    @if (isset($overlay))
                        <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/5 to-transparent pointer-events-none"></div>
                        <div class="hero-overlay hidden md:block">{{ $overlay }}</div>
                    @elseif (count($card))
                        <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/0 to-transparent pointer-events-none"></div>
                        <div class="hero-card">
                            @foreach ($card as $i => [$cardIcon, $cardTitle, $cardSub])
                                <div class="hero-card-item" style="--i: {{ $i }}">
                                    <i class="ph-duotone ph-{{ $cardIcon }}"></i>
                                    <span><b>{{ $cardTitle }}</b><span>{{ $cardSub }}</span></span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if (isset($overlay))
                    <div class="hero-overlay-mobile md:hidden">{{ $overlay }}</div>
                @endif
            </div>
        @else
            <div class="relative w-full max-w-[1440px] mx-auto -mt-2 sm:-mt-8 lg:-mt-16 select-none">
                <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 h-12 sm:h-16 bg-gradient-to-b from-white via-white/70 to-transparent z-10"></div>
                <x-img :src="$image" :alt="$alt" :eager="true" :w="2000" class="w-full h-auto block object-cover aspect-[16/9] max-h-[760px]" />
                @if (count($card))
                    <div class="absolute inset-x-0 bottom-5 md:bottom-10 z-10">
                      <div class="max-w-[1320px] mx-auto px-6 md:px-12">
                        <div class="hero-card hero-card-float">
                            @foreach ($card as $i => [$cardIcon, $cardTitle, $cardSub])
                                <div class="hero-card-item" style="--i: {{ $i }}">
                                    <i class="ph-duotone ph-{{ $cardIcon }}"></i>
                                    <span><b>{{ $cardTitle }}</b><span>{{ $cardSub }}</span></span>
                                </div>
                            @endforeach
                        </div>
                      </div>
                    </div>
                @endif
            </div>
        @endif
    @endif
</section>
