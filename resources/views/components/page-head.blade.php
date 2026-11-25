@props(['title', 'text' => null, 'cta' => null, 'modal' => null, 'href' => null])
{{-- Zenith hero editorial split, without the image stage --}}
<section class="bg-white">
    <div class="max-w-[1320px] mx-auto px-6 md:px-12 pt-8 md:pt-12 pb-12 md:pb-16">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 md:gap-12">
            <div>
                {{ $before ?? '' }}
                <h1 class="text-[clamp(2.45rem,4.7vw,4.35rem)] font-normal leading-[1.03] tracking-[-0.035em] text-[#111111] max-w-[720px]">{!! $title !!}</h1>
                @if ($cta)
                    <div class="mt-7 md:mt-8">
                        <a href="{{ $href ?? '#' }}" @if($modal) data-open-modal="{{ $modal }}" @endif class="zr-btn-hero">{{ $cta }}</a>
                    </div>
                @endif
            </div>
            @if ($text)
                <p class="text-[14px] leading-[1.58] text-[#6E6E6E] max-w-[295px] md:pt-2">{{ $text }}</p>
            @endif
        </div>
    </div>
</section>
