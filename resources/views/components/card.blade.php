@props(['href', 'image', 'title', 'right' => null, 'sub' => null, 'specs' => [], 'modal' => null, 'badge' => null])
{{-- Zenith property card: square photo, name + price, location, specs row --}}
<a href="{{ $href }}" @if($modal) data-open-modal="{{ $modal }}" @endif
   class="group bg-white border border-[#EAEAEA] hover:border-[#D0D0D0] transition-colors duration-200 text-left flex flex-col cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#111111]">
    <div class="aspect-square w-full overflow-hidden bg-[#EAEAEA] relative">
        <x-img :src="$image" :alt="$title" :w="900" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500 ease-out" />
        @if ($badge)
            <span class="absolute left-3 top-3 bg-white/95 text-[#111111] text-[10px] font-medium px-2 py-1 rounded-[2px]">{{ $badge }}</span>
        @endif
    </div>
    <div class="p-5 md:p-6 flex flex-col flex-1 justify-between">
        <div>
            <div class="flex items-baseline justify-between gap-3">
                <h3 class="text-[15px] font-medium text-[#111111] tracking-[-0.01em]">{{ $title }}</h3>
                @if ($right)<span class="text-[15px] font-medium text-[#111111] tabular-nums shrink-0">{{ $right }}</span>@endif
            </div>
            @if ($sub)<p class="text-[11px] text-[#8A8A8A] mt-0.5">{{ $sub }}</p>@endif
        </div>
        @if (count($specs))
            <div class="pt-4 mt-4 border-t border-[#F2F2F2] flex flex-wrap items-center gap-x-4 gap-y-1.5 text-[11px] text-[#737373] tabular-nums">
                @foreach ($specs as [$icon, $text])
                    <span class="inline-flex items-center gap-1.5 whitespace-nowrap">
                        <i class="ph-duotone ph-{{ $icon }} text-[13px] text-[#8C8C8C]"></i>
                        <span>{{ $text }}</span>
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</a>
