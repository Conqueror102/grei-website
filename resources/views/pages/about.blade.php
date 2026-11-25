<x-layouts.app title="Company" description="GREI is a multidisciplinary property and interior design company connecting real estate, bespoke interiors and curated hospitality.">
    <x-hero title="To elevate the way people<br>discover, create and<br>experience spaces" cta="Book a call" modal="modal-call" :image="config('grei.images.about_hero')" :framed="true"
        alt="Bright design studio with soft seating and timber shelving"
        eyebrow="The company" icon="compass-tool"
        :chips="[['buildings', 'Real estate'], ['armchair', 'Interiors'], ['bed', 'Stays']]"
        :card="[['users-three', 'One team', 'Property, design, hosting'], ['seal-check', 'One standard', 'From brief to handover'], ['map-pin-line', 'Local insight', 'Advised privately']]"
        text="GREI, Global Real Estate &amp; Interior Design, is a multidisciplinary property and interior design company connecting real estate, bespoke interiors and curated hospitality." />

    <section class="bg-[#F5F5F5] pt-20 md:pt-24 pb-16 md:pb-20">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <x-split-head title="Property expertise and<br>creative vision, together">
                We deliver spaces that balance aesthetic distinction with everyday functionality, for homeowners, investors, businesses and travellers.
            </x-split-head>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ([
                    ['magnifying-glass', 'Discover Real Estate', 'Connecting clients with exceptional residential, commercial and investment opportunities.', route('real-estate.index')],
                    ['paint-brush-household', 'Transform Interiors', 'Thoughtfully designed residential, commercial and hospitality interiors.', route('interiors.index')],
                    ['key', 'Experience Stays', 'Refined short stays for executives, expatriates and visiting professionals.', route('stays.index')],
                ] as [$icon, $h, $t, $href])
                    <a href="{{ $href }}" class="group bg-white border border-[#EAEAEA] hover:border-[#D0D0D0] transition-colors p-6 md:p-7 flex flex-col">
                        <i class="ph-duotone ph-{{ $icon }} text-[26px] text-[#111111]"></i>
                        <h3 class="mt-5 text-[15px] font-medium tracking-[-0.01em]">{{ $h }}</h3>
                        <p class="mt-2 text-[13px] leading-[1.6] text-[#737373]">{{ $t }}</p>
                        <span class="mt-6 pt-4 border-t border-[#F2F2F2] text-[11px] text-[#737373] inline-flex items-center gap-1.5 group-hover:text-[#111111]">Explore <i class="ph-duotone ph-arrow-right text-[12px]"></i></span>
                    </a>
                @endforeach
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border border-[#EAEAEA] p-8 sm:p-10">
                    <p class="text-[11px] font-medium tracking-[0.08em] uppercase text-[#8A8A8A]">Vision</p>
                    <p class="mt-3 text-[20px] leading-[1.4] tracking-[-0.015em]">To become a recognised, design-led real estate and interiors brand, known for a considered approach to spaces and a commitment to quality, trust and lasting value.</p>
                </div>
                <div class="bg-white border border-[#EAEAEA] p-8 sm:p-10">
                    <p class="text-[11px] font-medium tracking-[0.08em] uppercase text-[#8A8A8A]">Mission</p>
                    <p class="mt-3 text-[20px] leading-[1.4] tracking-[-0.015em]">To connect clients with exceptional property, create thoughtfully designed interiors and deliver refined hospitality through expertise, creativity and personalised service.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white pt-20 md:pt-24 pb-16 md:pb-20">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <x-split-head title="Five words we<br>hold ourselves to">They guide how we advise, design and host.</x-split-head>
            <div class="grid grid-cols-2 md:grid-cols-5 border border-[#EAEAEA]">
                @foreach ([['Trustworthy', 'handshake'], ['Refined', 'diamond'], ['Intentional', 'target'], ['Considered', 'compass-tool'], ['Contemporary', 'sparkle']] as $i => [$v, $icon])
                    <div class="p-6 {{ $i ? 'border-l border-[#F2F2F2]' : '' }} {{ $i >= 2 ? 'max-md:border-t' : '' }}">
                        <i class="ph-duotone ph-{{ $icon }} text-[22px]"></i>
                        <p class="mt-4 text-[15px] font-medium">{{ $v }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-feature title="Work with<br>GREI" :image="config('grei.images.about_team')" button="Free consult" modal="modal-consult" pad="pt-20 pb-20 md:pb-28">
        Homeowners, investors, private and corporate clients, and executive travellers. Tell us what you need and we'll take it from there.
    </x-feature>
</x-layouts.app>
