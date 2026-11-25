<x-layouts.app title="Real Estate" description="Residential, commercial and investment property, advised privately by GREI.">
    <x-hero title="Discover property you<br>truly belong in" cta="Book a call" modal="modal-call" :framed="true"
        :image="config('grei.images.real_estate_page')" alt="White contemporary villa with an infinity pool and lawn"
        eyebrow="GREI Real Estate" icon="house-line"
        text="Residential, commercial and investment opportunities, many offered privately. Tell us your brief and a consultant curates a shortlist for you."
        :chips="[['house', 'Residential'], ['storefront', 'Commercial'], ['chart-line-up', 'Investment']]"
        :card="[['lock-key', 'Off-market access', 'Many homes never listed'], ['magnifying-glass', 'Due diligence', 'Checked before you view'], ['handshake', 'Private viewings', 'On your schedule']]" />

    <section id="properties-section" class="bg-[#F5F5F5] pt-16 md:pt-20 pb-16 md:pb-20">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
                <div class="flex flex-wrap gap-2" role="group" aria-label="Property type">
                    @php($base = request()->except('category'))
                    <a href="{{ route('real-estate.index', $base) }}" class="zr-chip" aria-current="{{ empty($filters['category']) ? 'true' : 'false' }}">All ({{ $properties->count() }})</a>
                    @foreach (\App\Models\Property::CATEGORIES as $key => $label)
                        <a href="{{ route('real-estate.index', $base + ['category' => $key]) }}" class="zr-chip" aria-current="{{ ($filters['category'] ?? null) === $key ? 'true' : 'false' }}">{{ $label }}</a>
                    @endforeach
                </div>
                <form method="GET" class="flex flex-wrap items-end gap-3">
                    @if(!empty($filters['category']))<input type="hidden" name="category" value="{{ $filters['category'] }}">@endif
                    <label class="w-44"><span class="zr-label">Purpose</span>
                        <select name="type" class="zr-input" onchange="this.form.submit()">
                            <option value="">Any</option>
                            @foreach (\App\Models\Property::LISTING_TYPES as $key => $label)
                                <option value="{{ $key }}" @selected(($filters['type'] ?? null) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="w-44"><span class="zr-label">City</span>
                        <select name="city" class="zr-input" onchange="this.form.submit()">
                            <option value="">Anywhere</option>
                            @foreach ($cities as $city)
                                <option @selected(($filters['city'] ?? null) === $city)>{{ $city }}</option>
                            @endforeach
                        </select>
                    </label>
                    <noscript><button class="zr-btn-dark">Filter</button></noscript>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($properties as $property)
                    <x-property-card :property="$property" />
                @empty
                    <div class="md:col-span-3 bg-white border border-[#EAEAEA] p-12 text-center">
                        <i class="ph-duotone ph-magnifying-glass text-[32px] text-[#8C8C8C]"></i>
                        <p class="mt-3 text-[15px] font-medium">Nothing listed that matches, yet.</p>
                        <p class="mt-1 text-[13px] text-[#737373]">Much of our portfolio is offered privately. Ask a consultant.</p>
                        <button type="button" data-open-modal="modal-consult" class="zr-btn-outline mt-6">Free consult</button>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <x-feature title="Off-market<br>opportunities" :image="config('grei.images.real_estate_hero')" button="Free consult" modal="modal-consult">
        Consultants curate custom lists of vetted homes and assets. Title checks, valuation and private viewings handled for you, then hand over to GREI Interiors or GREI Stays.
    </x-feature>

    @foreach ($properties as $property)
        <x-property-modals :property="$property" />
    @endforeach
</x-layouts.app>
