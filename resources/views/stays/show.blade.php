@php
    $s = $stay;
    $amenityIcons = ['wifi' => 'wifi-high', 'desk' => 'desk', 'power' => 'lightning', 'car' => 'car-profile', 'broom' => 'broom', 'shield' => 'shield-check', 'snowflake' => 'snowflake', 'coffee' => 'coffee', 'pool' => 'swimming-pool', 'gym' => 'barbell', 'tv' => 'television-simple', 'chef' => 'chef-hat', 'tree' => 'tree'];
    $requested = session('stay_requested');
    $sym = config('grei.currency.symbol');
@endphp
<x-layouts.app :title="$s->title" :description="$s->summary">
    <section class="bg-white">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12 pt-8 md:pt-12 pb-16">
            <x-back-link :href="route('stays.index')">All stays</x-back-link>
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-[clamp(2.2rem,4vw,3.6rem)] font-normal leading-[1.05] tracking-[-0.035em]">{{ $s->title }}</h1>
                    <p class="inline-flex items-center gap-1.5 text-[13px] text-[#737373] mt-3"><i class="ph-duotone ph-map-pin text-[15px]"></i>{{ $s->location }} <span aria-hidden="true">·</span> {{ $s->type }}</p>
                </div>
                <div class="text-[26px] font-medium tabular-nums">{{ $s->rate_label }} <span class="text-[14px] font-normal text-[#737373]">/ night</span></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8 space-y-6">
                    <div class="aspect-[16/10] w-full overflow-hidden bg-[#EAEAEA]">
                        <x-img :src="$s->cover" :alt="$s->title" :w="1800" :eager="true" class="w-full h-full object-cover" />
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-4 border-y border-[#EFEFEF] text-[13px] text-[#525252]">
                        <div class="flex items-center gap-2"><i class="ph-duotone ph-users text-[14px] text-[#8C8C8C]"></i>Up to {{ $s->max_guests }} guests</div>
                        <div class="flex items-center gap-2"><i class="ph-duotone ph-bed text-[14px] text-[#8C8C8C]"></i>{{ $s->bedrooms }} {{ Str::plural('bedroom', $s->bedrooms) }}</div>
                        <div class="flex items-center gap-2"><i class="ph-duotone ph-bathtub text-[14px] text-[#8C8C8C]"></i>{{ $s->bathrooms }} {{ Str::plural('bathroom', $s->bathrooms) }}</div>
                        <div class="flex items-center gap-2"><i class="ph-duotone ph-moon-stars text-[14px] text-[#8C8C8C]"></i>Min {{ $s->min_nights }} {{ Str::plural('night', $s->min_nights) }}</div>
                    </div>
                    <div class="space-y-4 text-[14px] leading-[1.7] text-[#525252] max-w-[720px]">
                        @foreach (preg_split("/\n\n+/", $s->description) as $para)<p>{{ $para }}</p>@endforeach
                    </div>
                    <div>
                        <h2 class="text-[15px] font-medium mb-4">What's included</h2>
                        <ul class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-3 text-[13px] text-[#525252]">
                            @foreach ($s->amenities as $key => $label)
                                <li class="flex items-center gap-2"><i class="ph-duotone ph-{{ $amenityIcons[$key] ?? 'check' }} text-[18px] text-[#111111]"></i>{{ $label }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @if (count($s->gallery) > 1)
                        <div class="grid grid-cols-2 gap-6">
                            @foreach (array_slice($s->gallery, 1, 4) as $img)
                                <div class="aspect-square overflow-hidden bg-[#EAEAEA]"><x-img :src="$img" :alt="$s->title" :w="900" class="w-full h-full object-cover" /></div>
                            @endforeach
                        </div>
                    @endif
                    <div class="grid grid-cols-3 gap-3 py-4 border-y border-[#EFEFEF] text-[13px]">
                        <p><span class="block text-[11px] text-[#8A8A8A]">Check in</span>From {{ $s->check_in }}</p>
                        <p><span class="block text-[11px] text-[#8A8A8A]">Check out</span>By {{ $s->check_out }}</p>
                        <p><span class="block text-[11px] text-[#8A8A8A]">Payment</span>{{ $mode === 'request' ? 'Arranged on confirmation' : 'Online at booking' }}</p>
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-6 bg-white border border-[#EAEAEA] p-6 sm:p-8" id="request">
                        <div class="flex items-baseline justify-between border-b border-[#EFEFEF] pb-4">
                            <h2 class="text-[22px] font-normal tracking-[-0.02em]">{{ $mode === 'request' ? 'Request to book' : 'Book your stay' }}</h2>
                            <span class="bg-[#111111] text-white text-[10px] font-medium px-1.5 py-[2px] rounded-[2px] leading-none">{{ $s->rate_label }}/night</span>
                        </div>

                        @if ($requested)
                            <div role="status" class="mt-5 text-center space-y-3 border border-[#EAEAEA] bg-[#F5F5F5] p-5">
                                <div class="w-10 h-10 bg-[#111111] text-white mx-auto flex items-center justify-center rounded-[2px]"><i class="ph-duotone ph-check text-[20px]"></i></div>
                                <p class="text-[15px] font-medium">Request {{ $requested['reference'] }} received</p>
                                <p class="text-[12px] leading-[1.6] text-[#6E6E6E]">{{ \Carbon\Carbon::parse($requested['check_in'])->format('j M') }} – {{ \Carbon\Carbon::parse($requested['check_out'])->format('j M Y') }}, {{ $requested['nights'] }} {{ Str::plural('night', $requested['nights']) }}, {{ $requested['guests'] }} {{ Str::plural('guest', $requested['guests']) }}. Estimated {{ $sym }}{{ number_format($requested['estimated_total']) }}. We'll confirm availability and payment by email.</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('stays.request', $s) }}" class="mt-5 space-y-4" data-stay-quote data-rate="{{ $s->nightly_rate }}" data-min-nights="{{ $s->min_nights }}" data-symbol="{{ $sym }}">
                            @csrf
                            <div class="hidden" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
                            @if ($errors->any())
                                <div class="text-[12px] text-red-700 bg-red-50 border border-red-200 px-3 py-2">{{ $errors->first() }}</div>
                            @endif
                            <div class="grid grid-cols-2 gap-4">
                                <label><span class="zr-label">Check In</span><input type="date" name="check_in" class="zr-input" value="{{ old('check_in', request('check_in')) }}" min="{{ now()->toDateString() }}" required></label>
                                <label><span class="zr-label">Check Out</span><input type="date" name="check_out" class="zr-input" value="{{ old('check_out', request('check_out')) }}" min="{{ now()->addDay()->toDateString() }}" required></label>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <label><span class="zr-label">Guests</span>
                                    <select name="guests" class="zr-input">
                                        @foreach (range(1, $s->max_guests) as $g)<option value="{{ $g }}" @selected((int) old('guests', request('guests', min(2, $s->max_guests))) === $g)>{{ $g }}</option>@endforeach
                                    </select>
                                </label>
                                <label><span class="zr-label">Purpose</span>
                                    <select name="purpose" class="zr-input">
                                        <option value="business" @selected(old('purpose') === 'business')>Business</option>
                                        <option value="leisure" @selected(old('purpose') === 'leisure')>Leisure</option>
                                        <option value="relocation" @selected(old('purpose') === 'relocation')>Relocation</option>
                                    </select>
                                </label>
                            </div>
                            <div class="py-3 border-y border-[#EFEFEF] text-[13px] text-[#525252]" data-quote-output aria-live="polite"></div>
                            <label class="block"><span class="zr-label">Full Name</span><input name="name" class="zr-input" value="{{ old('name') }}" required autocomplete="name" placeholder="Adaeze Okafor"></label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2 gap-4">
                                <label><span class="zr-label">Email Address</span><input type="email" name="email" class="zr-input" value="{{ old('email') }}" required autocomplete="email" placeholder="you@company.com"></label>
                                <label><span class="zr-label">Phone (Optional)</span><input type="tel" name="phone" class="zr-input" value="{{ old('phone') }}" autocomplete="tel"></label>
                            </div>
                            <label class="block"><span class="zr-label">Notes</span><textarea name="message" rows="3" class="zr-input resize-none" placeholder="Arrival time, airport pickup, company invoicing...">{{ old('message') }}</textarea></label>
                            <button class="w-full inline-flex items-center justify-center gap-2 bg-[#111111] hover:bg-[#262626] text-white text-[12px] font-medium tracking-[0.04em] uppercase px-6 py-3.5 rounded-[2px] transition-colors cursor-pointer">
                                <i class="ph-duotone ph-calendar-check text-[14px]"></i>{{ $mode === 'request' ? 'Request These Dates' : 'Book Now' }}
                            </button>
                            @if ($mode === 'request')<p class="text-center text-[11px] text-[#8A8A8A]">No payment taken now. We confirm availability first.</p>@endif
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if ($others->isNotEmpty())
        <section class="bg-[#F5F5F5] pt-20 pb-20">
            <div class="max-w-[1320px] mx-auto px-6 md:px-12">
                <x-split-head title="Other<br>residences">Hosted to the same standard by the GREI team.</x-split-head>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($others as $o)<x-stay-card :stay="$o" />@endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
