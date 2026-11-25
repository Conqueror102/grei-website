<x-layouts.app title="Interiors" description="Bespoke residential, commercial and hospitality interiors by the GREI studio.">
    <x-hero title="Interiors that balance<br>distinction and daily life" cta="Start a project" href="#start" :image="config('grei.images.interiors_hero')" :framed="true"
        alt="Bright living room with a blue sofa, herringbone floor and plants"
        eyebrow="GREI Interiors studio" icon="armchair"
        :chips="[['house', 'Residential'], ['storefront', 'Commercial'], ['bed', 'Hospitality']]"
        :card="[['pencil-ruler', 'Concept to install', 'One accountable studio'], ['hammer', 'Bespoke joinery', 'Made for the space'], ['package', 'Procurement', 'Sourced and delivered']]"
        text="Residential, commercial and hospitality interiors, designed and delivered by one studio, from the first conversation to the final installation." />

    {{-- Services, Zenith card language --}}
    <section class="bg-[#F5F5F5] pt-20 md:pt-24 pb-16 md:pb-20">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <x-split-head title="One studio, accountable<br>for every detail">
                A clear process means honest budgets, fewer surprises and a finished space that works on day one.
            </x-split-head>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([
                    ['house-line', 'Residential', 'Full homes, single rooms and furnishing packages for new and existing properties.'],
                    ['briefcase', 'Commercial', 'Offices, client lounges and retail spaces that express who you are.'],
                    ['bed', 'Hospitality', 'Serviced apartments and suites designed to perform for owners and delight guests.'],
                    ['ruler', 'Consultancy', 'Concept, layout and specification for clients who build with their own teams.'],
                ] as [$icon, $h, $t])
                    <div class="bg-white border border-[#EAEAEA] p-6 md:p-7">
                        <i class="ph-duotone ph-{{ $icon }} text-[26px] text-[#111111]"></i>
                        <h3 class="mt-5 text-[15px] font-medium tracking-[-0.01em]">{{ $h }}</h3>
                        <p class="mt-2 text-[13px] leading-[1.6] text-[#737373]">{{ $t }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 bg-white border border-[#EAEAEA] grid grid-cols-1 md:grid-cols-4">
                @foreach ([['Listen', 'How you live or work, timeline and budget.'], ['Design', 'Concept, layouts, materials and a costed specification.'], ['Deliver', 'Joinery, procurement and site management.'], ['Handover', 'Styled, cleaned and ready, with aftercare.']] as $i => [$h, $t])
                    <div class="p-6 md:p-7 {{ $i ? 'border-t md:border-t-0 md:border-l border-[#F2F2F2]' : '' }}">
                        <p class="text-[11px] text-[#8A8A8A] tabular-nums">0{{ $i + 1 }}</p>
                        <p class="mt-2 text-[15px] font-medium">{{ $h }}</p>
                        <p class="mt-1 text-[12px] leading-[1.6] text-[#737373]">{{ $t }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Portfolio --}}
    <section id="portfolio" class="bg-white pt-20 md:pt-24 pb-16 md:pb-20 scroll-mt-6">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <x-split-head title="Selected<br>projects">
                Homes, workplaces and hospitality spaces completed by the GREI studio.
                <x-slot:after>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('interiors.index') }}#portfolio" class="zr-chip" aria-current="{{ $sector ? 'false' : 'true' }}">All</a>
                        @foreach (\App\Models\Project::SECTORS as $key => $label)
                            <a href="{{ route('interiors.index', ['sector' => $key]) }}#portfolio" class="zr-chip" aria-current="{{ $sector === $key ? 'true' : 'false' }}">{{ $label }}</a>
                        @endforeach
                    </div>
                </x-slot:after>
            </x-split-head>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($projects as $project)
                    <x-project-card :project="$project" />
                @empty
                    <p class="text-[13px] text-[#737373]">New projects in this sector are coming soon.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Start a project: Zenith split with the form in the card --}}
    <section id="start" class="bg-[#F5F5F5] pt-20 pb-20 md:pb-28 scroll-mt-6">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <div class="lg:col-span-5 bg-white border border-[#EAEAEA] p-8 sm:p-10">
                    <h2 class="text-[28px] md:text-[32px] font-normal leading-[1.15] tracking-[-0.025em]">Start a<br>project</h2>
                    <div class="mt-6">
                        <x-consult-form type="interior" topic="Interior design project" :cancel="false" submit="Request Consultation"
                            intro="A short description is enough to begin. We'll arrange a design consultation at your property or our studio." message-label="About Your Space" />
                    </div>
                </div>
                <div class="lg:col-span-7 bg-[#EAEAEA] overflow-hidden min-h-[320px]">
                    <x-img :src="config('grei.images.approach')" :w="1400" alt="Interior detail" class="w-full h-full object-cover" />
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
