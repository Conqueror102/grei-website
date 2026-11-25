@props(['title', 'image', 'button' => null, 'modal' => null, 'href' => '#', 'reverse' => false, 'alt' => '', 'id' => null, 'bg' => 'bg-[#F5F5F5]', 'pad' => 'pb-20 md:pb-28'])
{{-- Zenith "Exclusive collection" split: white editorial card + large visual --}}
<section @if($id) id="{{ $id }}" @endif class="{{ $bg }} {{ $pad }} scroll-mt-6">
    <div class="max-w-[1320px] mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            <div class="lg:col-span-4 bg-white border border-[#EAEAEA] p-8 sm:p-10 md:p-12 flex flex-col justify-center {{ $reverse ? 'lg:order-2' : '' }}">
                <h2 class="text-[28px] md:text-[32px] font-normal leading-[1.15] tracking-[-0.025em] text-[#111111]">{!! $title !!}</h2>
                <div class="mt-4 text-[13px] leading-[1.62] text-[#737373] max-w-[280px]">{{ $slot }}</div>
                @if ($button)
                    <div class="mt-8">
                        <a href="{{ $href }}" @if($modal) data-open-modal="{{ $modal }}" @endif class="zr-btn-outline !px-6 !py-2.5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#111111]">{{ $button }}</a>
                    </div>
                @endif
            </div>
            <div class="lg:col-span-8 bg-[#EAEAEA] overflow-hidden min-h-[320px] sm:min-h-[420px] lg:min-h-[480px] {{ $reverse ? 'lg:order-1' : '' }}">
                <x-img :src="$image" :alt="$alt" :w="1600" class="w-full h-full object-cover block" />
            </div>
        </div>
    </div>
</section>
