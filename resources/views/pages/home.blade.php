<x-layouts.app>
    <x-hero title="Discover, create and<br>experience space" cta="Book a call" modal="modal-call" :image="config('grei.images.home_hero')"
        eyebrow="GREI Group · Real estate, interiors, stays" icon="buildings"
        :card="[['house-line', 'Real estate', 'Buy, sell, invest'], ['armchair', 'Interiors', 'Design and build'], ['bed', 'Stays', 'Hosted residences']]"
        alt="Contemporary dark two-storey residence with glazed facade and landscaped driveway"
        text="Property, interiors and premium stays from one considered team, so the home you buy, the space you shape and the place you stay meet one standard." />

    {{-- Discover real estate: Zenith featured properties --}}
    <section id="properties-section" class="bg-[#F5F5F5] pt-20 md:pt-24 pb-16 md:pb-20">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <x-split-head title="Guiding you toward the<br>property of your ambitions">
                Residential, commercial and investment opportunities, advised privately. Our vision bridges balance, design and attention so every client owns a space that reflects their values.
                <x-slot:after>
                    <a href="{{ route('real-estate.index') }}" class="mt-2 inline-block text-[12px] font-medium text-[#111111] underline underline-offset-4 hover:text-[#525252]">View all properties</a>
                </x-slot:after>
            </x-split-head>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($properties as $property)
                    <x-property-card :property="$property" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Exclusive collection, as in Zenith --}}
    <x-feature id="exclusive-collection" title="Exclusive<br>collection" :image="config('grei.images.pillar_real_estate')" button="Free consult" modal="modal-consult"
        alt="Sculptural white residence framed by olive trees">
        Consultants curate custom lists of vetted homes and investment opportunities, many never publicly listed. Private viewings and full due diligence included.
    </x-feature>

    {{-- Transform interiors --}}
    <section class="bg-white pt-20 md:pt-24 pb-16 md:pb-20">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <x-split-head title="Interiors designed around<br>how you live and work">
                Residential, commercial and hospitality interiors, from first concept and bespoke joinery to procurement and installation, delivered by one accountable studio.
                <x-slot:after>
                    <a href="{{ route('interiors.index') }}" class="mt-2 inline-block text-[12px] font-medium text-[#111111] underline underline-offset-4 hover:text-[#525252]">See the portfolio</a>
                </x-slot:after>
            </x-split-head>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($projects->prepend($project)->filter() as $p)
                    <x-project-card :project="$p" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Experience stays --}}
    <section class="bg-[#F5F5F5] pt-20 md:pt-24 pb-16 md:pb-20">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <x-split-head title="Premium stays for<br>executives and expats">
                Furnished by our interiors studio and hosted by our own team. Airport meet-and-greet, uninterrupted power, a proper workspace and a host on call.
                <x-slot:after>
                    <a href="{{ route('stays.index') }}" class="mt-2 inline-block text-[12px] font-medium text-[#111111] underline underline-offset-4 hover:text-[#525252]">All stays</a>
                </x-slot:after>
            </x-split-head>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($stays as $stay)
                    <x-stay-card :stay="$stay" />
                @endforeach
            </div>
        </div>
    </section>

    <x-feature title="Corporate<br>accommodation" :image="config('grei.images.pillar_stays')" button="Book a call" modal="modal-call" :reverse="true"
        alt="Calm hotel-style bedroom with neutral linens">
        Long stays and relocation housing for visiting executives and teams, with one point of contact, preferred rates and monthly invoicing.
    </x-feature>

    {{-- Closing call to action: full-photo glass carousel across the three pillars --}}
    <section class="bg-white pt-4 md:pt-6">
        <x-hero-carousel :slides="[
            [
                'label' => 'Real Estate', 'icon' => 'house-line',
                'title' => 'Find the property of your ambitions',
                'text' => 'Residential, commercial and investment opportunities, many offered privately, with due diligence done before you view.',
                'tags' => [['lock-key', 'Off-market access'], ['chart-line-up', 'Investment'], ['handshake', 'Private viewings']],
                'cta' => 'Explore properties', 'href' => route('real-estate.index'),
                'secondary' => ['Free consult', route('book', ['for' => 'consult'])],
                'image' => config('grei.images.slide_real_estate'), 'alt' => 'Modern timber-clad home lit up at dusk',
            ],
            [
                'label' => 'Interiors', 'icon' => 'armchair',
                'title' => 'Spaces designed around how you live',
                'text' => 'From first concept and bespoke joinery to procurement and installation, delivered by one accountable studio.',
                'tags' => [['pencil-ruler', 'Concept to install'], ['hammer', 'Bespoke joinery'], ['package', 'Procurement']],
                'cta' => 'See interiors', 'href' => route('interiors.index'),
                'secondary' => ['Start a project', route('book', ['for' => 'consult'])],
                'image' => config('grei.images.slide_interiors'), 'alt' => 'Bright double-height living room with a stone fireplace',
            ],
            [
                'label' => 'Stays', 'icon' => 'bed',
                'title' => 'Your home away from home',
                'text' => 'Premium residences furnished by our studio and hosted by our own team, for executives, relocations and family visits.',
                'tags' => [['airplane-landing', 'Airport pickup'], ['lightning', 'Uninterrupted power'], ['headset', 'Host on call']],
                'cta' => 'Find a stay', 'href' => route('stays.index'),
                'secondary' => ['Corporate stays', route('book', ['for' => 'call'])],
                'image' => config('grei.images.slide_stays'), 'alt' => 'Hotel pool and open lounge lit at dusk',
            ],
        ]" />
    </section>

    @foreach ($properties as $property)
        <x-property-modals :property="$property" />
    @endforeach
</x-layouts.app>
