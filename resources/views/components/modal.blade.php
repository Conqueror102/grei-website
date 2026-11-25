@props(['id', 'title', 'max' => 'max-w-xl', 'autoshow' => false])
{{-- Zenith ModalShell --}}
<div id="{{ $id }}" data-modal @if($autoshow) data-autoshow @endif hidden role="dialog" aria-modal="true" aria-label="{{ strip_tags($title) }}"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-black/45 backdrop-blur-[2px]">
    <div class="w-full {{ $max }} bg-white border border-[#E5E5E5] shadow-[0_24px_64px_rgba(0,0,0,0.18)] max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#EFEFEF] sticky top-0 bg-white z-10">
            <h3 class="text-[15px] font-medium text-[#111111] tracking-[-0.01em]">{!! $title !!}</h3>
            <button type="button" data-close-modal aria-label="Close modal" class="w-8 h-8 inline-flex items-center justify-center text-[#737373] hover:text-[#111111] hover:bg-[#F5F5F5] transition-colors cursor-pointer">
                <i class="ph-duotone ph-x text-[16px]"></i>
            </button>
        </div>
        <div class="p-6">{{ $slot }}</div>
    </div>
</div>
