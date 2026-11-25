@php
    $link = 'hover:text-[#666666] transition-colors whitespace-nowrap shrink-0 cursor-pointer py-1 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#111111]';
    $item = 'block w-full text-left px-4 py-2 text-[13px] text-[#525252] hover:text-[#111111] hover:bg-black/[0.04] transition-colors';
    $active = fn ($p) => request()->routeIs($p) ? 'text-[#111111] underline underline-offset-[6px] decoration-1' : '';
@endphp
{{-- Zenith Navbar --}}
<header data-glass-header class="gr-glass sticky top-0 w-full z-40">
    <div class="max-w-[1320px] mx-auto px-6 md:px-12 h-20 flex items-center justify-between gap-8">
        {{-- Zone 1: brand (GREI mark + stacked wordmark, Zenith style) --}}
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 shrink-0 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#111111]" aria-label="GREI Group Home">
            <img src="{{ asset('images/brand/grei-mark-dark-tight.png') }}" alt="" class="h-9 w-auto" width="152" height="160">
            <span class="inline-flex flex-col font-bold uppercase tracking-[-0.04em] leading-[0.86] text-[15px] text-[#111111] whitespace-nowrap">
                <span>GREI</span>
                <span>GROUP</span>
            </span>
        </a>

        {{-- Zone 2: primary navigation --}}
        <nav aria-label="Primary Navigation" class="hidden md:flex items-center gap-7 text-[13px] font-medium text-[#1F1F1F]">
            <div class="relative" data-dropdown>
                <button type="button" data-dropdown-toggle aria-expanded="false" class="inline-flex items-center gap-1 {{ $link }} {{ $active('real-estate.*') }}">
                    <span>Real Estate</span>
                    <i class="ph-duotone ph-caret-down text-[14px]"></i>
                </button>
                <div data-dropdown-menu hidden class="absolute left-0 top-full mt-3 w-52 gr-glass-menu shadow-[0_12px_32px_rgba(0,0,0,0.08)] py-1.5 z-50">
                    <a href="{{ route('real-estate.index') }}" class="{{ $item }} !text-[#111111]">All Properties</a>
                    <a href="{{ route('real-estate.index', ['category' => 'residential']) }}" class="{{ $item }}">Residential</a>
                    <a href="{{ route('real-estate.index', ['category' => 'commercial']) }}" class="{{ $item }}">Commercial</a>
                    <a href="{{ route('real-estate.index', ['category' => 'land']) }}" class="{{ $item }}">Land</a>
                    <div class="my-1 border-t border-[#F0F0F0]"></div>
                    <a href="{{ route('real-estate.index', ['type' => 'investment']) }}" class="{{ $item }} !text-[#111111] font-medium">Investment Opportunities</a>
                </div>
            </div>

            <div class="relative" data-dropdown>
                <button type="button" data-dropdown-toggle aria-expanded="false" class="inline-flex items-center gap-1 {{ $link }} {{ $active('interiors.*') }}">
                    <span>Interiors</span>
                    <i class="ph-duotone ph-caret-down text-[14px]"></i>
                </button>
                <div data-dropdown-menu hidden class="absolute left-0 top-full mt-3 w-56 gr-glass-menu shadow-[0_12px_32px_rgba(0,0,0,0.08)] py-1.5 z-50">
                    <a href="{{ route('interiors.index') }}" class="{{ $item }} !text-[#111111]">Services</a>
                    <a href="{{ route('interiors.index') }}#portfolio" class="{{ $item }}">Portfolio</a>
                    <a href="{{ route('interiors.index') }}#start" class="{{ $item }}">Start a Project</a>
                </div>
            </div>

            <a href="{{ route('stays.index') }}" class="inline-flex items-center gap-1.5 {{ $link }} {{ $active('stays.*') }}">
                <span>Stays</span>
                <span class="bg-[#111111] text-white text-[10px] font-medium px-1.5 py-[2px] rounded-[2px] leading-none no-underline">New</span>
            </a>
            <a href="{{ route('about') }}" class="{{ $link }} {{ $active('about') }}">Company</a>
            <a href="{{ route('contact') }}" class="{{ $link }} {{ $active('contact') }}">Contact</a>
        </nav>

        {{-- Zone 3: single header action --}}
        <div class="flex items-center gap-3 shrink-0">
            <button type="button" data-open-modal="modal-list" class="hidden sm:inline-flex items-center gap-2 border border-white/70 bg-white/45 hover:bg-white/75 hover:border-[#CCCCCC] shadow-[inset_0_1px_0_rgba(255,255,255,0.9)] text-[#111111] text-[12px] font-medium px-4 py-2 rounded-[2px] transition-colors whitespace-nowrap shrink-0 cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#111111]">
                <i class="ph-duotone ph-house text-[14px]"></i>
                <span>List a property</span>
            </button>
            <button type="button" data-mobile-toggle aria-expanded="false" aria-label="Open navigation menu" class="zr-burger md:hidden inline-flex items-center justify-center w-10 h-10 border border-white/70 bg-white/45 rounded-[2px] cursor-pointer">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div data-mobile-menu hidden class="md:hidden border-t border-white/60 bg-white/55 px-6 py-4 space-y-3">
        <a href="{{ route('real-estate.index') }}" class="block w-full text-left py-2 text-[14px] font-medium text-[#111111]">Real Estate</a>
        <a href="{{ route('interiors.index') }}" class="block w-full text-left py-2 text-[14px] font-medium text-[#111111]">Interiors</a>
        <a href="{{ route('stays.index') }}" class="flex items-center gap-2 w-full text-left py-2 text-[14px] font-medium text-[#111111]">
            <span>Stays</span><span class="bg-[#111111] text-white text-[10px] font-medium px-1.5 py-[2px] rounded-[2px]">New</span>
        </a>
        <a href="{{ route('about') }}" class="block w-full text-left py-2 text-[14px] font-medium text-[#111111]">Company</a>
        <a href="{{ route('contact') }}" class="block w-full text-left py-2 text-[14px] font-medium text-[#111111]">Contact</a>
        <div class="pt-2 border-t border-[#F0F0F0]">
            <button type="button" data-open-modal="modal-list" class="w-full inline-flex items-center justify-center gap-2 border border-[#E6E6E6] bg-white text-[#111111] text-[13px] font-medium px-4 py-2.5 rounded-[2px]">
                <i class="ph-duotone ph-house text-[16px]"></i><span>List a property</span>
            </button>
        </div>
    </div>
</header>
