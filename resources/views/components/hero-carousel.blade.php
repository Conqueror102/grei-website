@props(['slides' => []])
{{-- Home hero stage: full-photo slides with a liquid-glass panel (Real Estate, Interiors, Stays) --}}
<div class="hc" data-carousel data-interval="6500" role="region" aria-roledescription="carousel" aria-label="What GREI does">
    @foreach ($slides as $i => $slide)
        <figure class="hc-slide {{ $i === 0 ? 'is-active' : '' }}" data-slide role="group" aria-roledescription="slide" aria-label="{{ $i + 1 }} of {{ count($slides) }}: {{ $slide['label'] }}" aria-hidden="{{ $i === 0 ? 'false' : 'true' }}">
            <x-img :src="$slide['image']" :alt="$slide['alt']" :eager="$i === 0" :w="2400" class="hc-img" />
            <div aria-hidden="true" class="hc-shade"></div>
            <figcaption class="hc-panel book-glass">
                <span class="hc-label"><i class="ph-duotone ph-{{ $slide['icon'] }}"></i>{{ $slide['label'] }}</span>
                <h2 class="hc-title">{{ $slide['title'] }}</h2>
                <p class="hc-text">{{ $slide['text'] }}</p>
                <ul class="hc-tags">
                    @foreach ($slide['tags'] as [$tagIcon, $tag])
                        <li><i class="ph-duotone ph-{{ $tagIcon }}"></i>{{ $tag }}</li>
                    @endforeach
                </ul>
                <div class="hc-actions">
                    <a href="{{ $slide['href'] }}" class="stays-find" @if($i) tabindex="-1" @endif>{{ $slide['cta'] }}<i class="ph-duotone ph-arrow-right text-[15px]"></i></a>
                    @if (!empty($slide['secondary']))
                        <a href="{{ $slide['secondary'][1] }}" class="stays-ghost" @if($i) tabindex="-1" @endif>{{ $slide['secondary'][0] }}</a>
                    @endif
                </div>
            </figcaption>
        </figure>
    @endforeach

    <div class="hc-controls">
        <div class="hc-dots" role="tablist" aria-label="Choose a slide">
            @foreach ($slides as $i => $slide)
                <button type="button" role="tab" class="hc-dot" data-dot="{{ $i }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}" aria-label="{{ $slide['label'] }}">
                    <span class="hc-dot-name">{{ $slide['label'] }}</span><span class="hc-dot-bar"><span></span></span>
                </button>
            @endforeach
        </div>
        <div class="hc-arrows">
            <button type="button" class="hc-arrow" data-prev aria-label="Previous slide"><i class="ph-duotone ph-arrow-left"></i></button>
            <button type="button" class="hc-arrow" data-next aria-label="Next slide"><i class="ph-duotone ph-arrow-right"></i></button>
        </div>
    </div>
</div>
