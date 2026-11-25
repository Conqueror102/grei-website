<x-layouts.app title="Stays" description="Premium short stays for executives, expatriates and visiting professionals, furnished and hosted by GREI.">
    <x-hero title="Stay somewhere that<br>simply works" cta="Find a stay" href="#stay-search" overlay-id="stay-search" :framed="true"
        :image="config('grei.images.stays_page')" alt="Bright bedroom with a padded headboard and an en-suite beyond"
        eyebrow="GREI Stays" icon="bed"
        text="Premium apartments and villas for executive travel, relocation and family visits. Furnished by our interiors studio, hosted by our own team."
        :chips="[['airplane-landing', 'Airport pickup'], ['lightning', 'Uninterrupted power'], ['headset', 'Host on call']]">
        <x-slot:overlay>
            <form method="GET" action="{{ route('stays.index') }}" class="stays-search">
                <div class="book-glass rounded-[4px] p-4 md:p-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)_minmax(0,1fr)_minmax(0,.8fr)_auto] lg:items-end">
                    <label><span class="zr-label">Location</span>
                        <select name="city" class="zr-input">
                            <option value="">All locations</option>
                            @foreach ($cities as $city)<option @selected(($search['city'] ?? null) === $city)>{{ $city }}</option>@endforeach
                        </select>
                    </label>
                    <label><span class="zr-label">Check in</span><input type="date" name="check_in" class="zr-input" value="{{ $search['check_in'] ?? '' }}" min="{{ now()->toDateString() }}"></label>
                    <label><span class="zr-label">Check out</span><input type="date" name="check_out" class="zr-input" value="{{ $search['check_out'] ?? '' }}" min="{{ now()->addDay()->toDateString() }}"></label>
                    <label><span class="zr-label">Guests</span>
                        <select name="guests" class="zr-input">
                            @foreach (range(1, 8) as $g)<option value="{{ $g }}" @selected((int) ($search['guests'] ?? 2) === $g)>{{ $g }} {{ Str::plural('guest', $g) }}</option>@endforeach
                        </select>
                    </label>
                    <button class="stays-find"><i class="ph-duotone ph-magnifying-glass text-[16px]"></i>Find a stay</button>
                    @if ($errors->any())<p class="text-[12px] text-red-200 sm:col-span-2 lg:col-span-5">{{ $errors->first() }}</p>@endif
                </div>
            </form>
        </x-slot:overlay>
    </x-hero>

    <section id="residences" class="bg-[#F5F5F5] pt-16 md:pt-20 pb-16 md:pb-20 scroll-mt-20">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <x-split-head title="{{ $stays->count() }} {{ Str::plural('residence', $stays->count()) }}{{ !empty($search['city']) ? ' in '.$search['city'] : ' available' }}">
                @if ($mode === 'request')
                    Request your dates and we confirm availability within a few hours. No payment is taken until your stay is confirmed.
                @else
                    Book instantly and pay securely online.
                @endif
            </x-split-head>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($stays as $stay)
                    <x-stay-card :stay="$stay" />
                @empty
                    <div class="md:col-span-3 bg-white border border-[#EAEAEA] p-12 text-center">
                        <i class="ph-duotone ph-bed text-[32px] text-[#8C8C8C]"></i>
                        <p class="mt-3 text-[15px] font-medium">No residences match those details.</p>
                        <p class="mt-1 text-[13px] text-[#737373]">Try fewer guests or another location, or ask us. We often have more on request.</p>
                        <button type="button" data-open-modal="modal-call" class="zr-btn-outline mt-6">Ask the stays team</button>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <x-feature title="Corporate<br>accommodation" :image="config('grei.images.stays_hero')" button="Book a call" modal="modal-call" pad="pt-20 md:pt-28 pb-20 md:pb-28">
        Long stays and relocation housing for visiting executives and teams, with airport meet-and-greet, one point of contact and monthly invoicing.
    </x-feature>
</x-layouts.app>
