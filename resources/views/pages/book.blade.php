@php
    $types = [
        'call' => [
            'tab' => 'Advisory call',
            'icon' => 'phone-call',
            'eyebrow' => 'Private advisory call',
            'title' => 'Book time with<br>a GREI advisor',
            'lead' => 'A relaxed 30 minute conversation about the property you want, the space you are shaping or the stay you need. No obligation, no pressure.',
            'topic' => 'Advisory call',
            'submit' => 'Request my call',
            'image' => config('grei.images.book_call'),
            'alt' => 'Contemporary residence at dusk with glazed facade',
            'steps' => [
                ['calendar-check', 'Pick a day and time', 'Choose what suits you. We confirm by email within one working day.'],
                ['chats-circle', 'Talk it through', 'Your advisor listens, asks the right questions and gives honest advice.'],
                ['list-checks', 'Get a clear next step', 'A shortlist, a design brief or a stay proposal, sent after the call.'],
            ],
        ],
        'consult' => [
            'tab' => 'Free consult',
            'icon' => 'compass-tool',
            'eyebrow' => 'Free design and property consult',
            'title' => 'Plan your next<br>space with us',
            'lead' => 'Tell us what you are looking for and a consultant prepares a bespoke shortlist of vetted properties, interior concepts or stays, free of charge.',
            'topic' => 'Free consult',
            'submit' => 'Book my consult',
            'image' => config('grei.images.book_consult'),
            'alt' => 'Warm, layered living room designed by an interiors studio',
            'steps' => [
                ['note-pencil', 'Share your brief', 'Budget, location, style and timing. As much or as little as you know.'],
                ['magnifying-glass', 'We curate', 'Vetted homes, design concepts or residences, many never publicly listed.'],
                ['handshake', 'Meet and decide', 'Walk through the options with your consultant, in person or on video.'],
            ],
        ],
        'list' => [
            'tab' => 'List a property',
            'icon' => 'house-line',
            'eyebrow' => 'Sell, let or place with GREI',
            'title' => 'List your property<br>with GREI',
            'lead' => 'Selling, letting, or placing your home into GREI Stays? Book a valuation and an advisor will visit, assess and advise on the best route.',
            'topic' => 'List a property',
            'submit' => 'Book a valuation',
            'image' => config('grei.images.book_list'),
            'alt' => 'Sculptural white villa framed by olive trees',
            'steps' => [
                ['map-pin-line', 'Tell us about it', 'Location, size and whether you want to sell, let or host stays.'],
                ['clipboard-text', 'Valuation visit', 'An advisor assesses the property and the market around it.'],
                ['rocket-launch', 'Go to market', 'Photography, styling and private buyers or guests, handled for you.'],
            ],
        ],
    ];
    $t = $types[$for];
    $sent = session('enquiry_sent');
    $old = fn ($k, $d = null) => old('topic') === $t['topic'] ? old($k, $d) : $d;
@endphp
<x-layouts.app :title="$t['tab']" :description="strip_tags($t['lead'])" :confirm="false">
    <section class="bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[calc(100vh-80px)]">

            {{-- Visual: large photo with a glass "what to expect" panel --}}
            <aside class="lg:col-span-5 relative">
                <div class="relative h-[460px] sm:h-[520px] lg:h-[calc(100vh-80px)] lg:sticky lg:top-20 overflow-hidden bg-[#1a1a1a]">
                    <x-img :src="$t['image']" :alt="$t['alt']" :eager="true" :w="1600" class="w-full h-full object-cover block book-photo" />
                    <div aria-hidden="true" class="absolute inset-0 bg-[linear-gradient(180deg,rgba(0,0,0,.5)_0%,rgba(0,0,0,.12)_30%,rgba(0,0,0,.18)_55%,rgba(0,0,0,.78)_100%)]"></div>
                    <div class="absolute inset-0 flex flex-col justify-between p-6 sm:p-10">
                        <span class="self-start inline-flex items-center gap-2 text-white/90 text-[11px] font-medium uppercase tracking-[0.12em] px-3 py-1.5 rounded-[2px] book-glass">
                            <i class="ph-duotone ph-{{ $t['icon'] }} text-[14px]"></i>{{ $t['eyebrow'] }}
                        </span>
                        <div class="book-glass p-5 sm:p-6 rounded-[3px] max-w-[440px]">
                            <p class="text-white/70 text-[11px] font-medium uppercase tracking-[0.12em] mb-4">What to expect</p>
                            <ol class="space-y-4">
                                @foreach ($t['steps'] as $i => [$icon, $head, $body])
                                    <li class="flex gap-3.5 book-step" style="--i: {{ $i }}">
                                        <span class="shrink-0 w-8 h-8 inline-flex items-center justify-center rounded-[2px] bg-white/15 border border-white/25 text-white">
                                            <i class="ph-duotone ph-{{ $icon }} text-[16px]"></i>
                                        </span>
                                        <span>
                                            <span class="block text-white text-[14px] font-medium">{{ $head }}</span>
                                            <span class="block text-white/70 text-[12.5px] leading-[1.5] mt-0.5">{{ $body }}</span>
                                        </span>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Booking form --}}
            <div class="lg:col-span-7 bg-white">
                <div class="max-w-[680px] mx-auto px-6 md:px-12 py-10 md:py-14">
                    <nav aria-label="Booking type" class="book-tabs" style="--n: 3; --k: {{ array_search($for, array_keys($types)) }}">
                        @foreach ($types as $key => $type)
                            <a href="{{ route('book', ['for' => $key]) }}" aria-current="{{ $key === $for ? 'page' : 'false' }}">
                                <i class="ph-duotone ph-{{ $type['icon'] }}"></i><span>{{ $type['tab'] }}</span>
                            </a>
                        @endforeach
                        <span class="book-tabs-pill" aria-hidden="true"></span>
                    </nav>

                    <h1 class="mt-10 text-[clamp(2.1rem,3.6vw,3.25rem)] font-normal leading-[1.05] tracking-[-0.035em] text-[#111111]">{!! $t['title'] !!}</h1>
                    <p class="mt-4 text-[14px] leading-[1.6] text-[#6E6E6E] max-w-[520px]">{{ $t['lead'] }}</p>

                    @if ($sent)
                        <div class="mt-10 border border-[#EAEAEA] bg-[#F7F7F7] p-8 sm:p-10 book-done">
                            <div class="w-11 h-11 bg-[#111111] text-white flex items-center justify-center rounded-[2px]">
                                <i class="ph-duotone ph-check text-[22px]"></i>
                            </div>
                            <h2 class="mt-6 text-[24px] font-normal tracking-[-0.02em]">Request received</h2>
                            <p class="mt-2 text-[13.5px] leading-[1.6] text-[#6E6E6E] max-w-[440px]">Thank you. A GREI advisor will confirm by email within one working day. If it is urgent, call us on {{ config('grei.contact.phone') }}.</p>
                            <div class="mt-8 flex flex-wrap gap-3">
                                <a href="{{ route('home') }}" class="zr-btn-dark">Back to home</a>
                                <a href="{{ route('real-estate.index') }}" class="zr-btn-outline">Browse properties</a>
                            </div>
                        </div>
                    @else
                        <form method="POST" action="{{ route('enquiries.store') }}" class="mt-10 space-y-9">
                            @csrf
                            <input type="hidden" name="type" value="general">
                            <input type="hidden" name="topic" value="{{ $t['topic'] }}">
                            <div class="hidden" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>

                            @if ($errors->any())
                                <div class="text-[12.5px] text-red-700 bg-red-50 border border-red-200 px-4 py-3">{{ $errors->first() }}</div>
                            @endif

                            {{-- 1. When --}}
                            <fieldset class="book-group">
                                <legend class="book-legend"><span>01</span>{{ $for === 'list' ? 'When can we visit?' : 'When suits you?' }}</legend>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label><span class="zr-label">Preferred date</span>
                                        <input type="date" name="preferred_date" class="zr-input" min="{{ now()->toDateString() }}" value="{{ $old('preferred_date', now()->addDays(2)->toDateString()) }}">
                                    </label>
                                    <div>
                                        <span class="zr-label">Meeting format</span>
                                        <div class="grid grid-cols-3 gap-2">
                                            @foreach (($for === 'list' ? ['In person' => 'buildings', 'Video' => 'video-camera', 'Phone' => 'phone'] : ['Video' => 'video-camera', 'Phone' => 'phone', 'In person' => 'buildings']) as $label => $icon)
                                                <label class="zr-choice zr-choice-stack">
                                                    <input type="radio" name="format" value="{{ $label }}" @checked($old('format', $loop->first ? $label : null) === $label)>
                                                    <span><i class="ph-duotone ph-{{ $icon }}"></i>{{ $label }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <span class="zr-label">Time of day</span>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach (['Morning · 9–12', 'Midday · 12–3', 'Afternoon · 3–6', 'Any time'] as $slot)
                                            <label class="zr-choice">
                                                <input type="radio" name="timeline" value="{{ $slot }}" @checked($old('timeline', 'Any time') === $slot)>
                                                <span>{{ $slot }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </fieldset>

                            {{-- 2. What --}}
                            <fieldset class="book-group">
                                <legend class="book-legend"><span>02</span>{{ $for === 'list' ? 'About the property' : 'What is it about?' }}</legend>
                                @if ($for === 'list')
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <label><span class="zr-label">Property type</span>
                                            <select name="property_type" class="zr-input">
                                                @foreach (['Residential', 'Commercial', 'Land', 'Short-stay apartment'] as $pt)
                                                    <option @selected($old('property_type') === $pt)>{{ $pt }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><span class="zr-label">Location</span>
                                            <input name="location" class="zr-input" value="{{ $old('location') }}" placeholder="Area and city">
                                        </label>
                                    </div>
                                    <div class="mt-4">
                                        <span class="zr-label">I would like to</span>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach (['Sell', 'Let', 'Host as a GREI Stay', 'Not sure yet'] as $goal)
                                                <label class="zr-choice">
                                                    <input type="checkbox" name="interests[]" value="{{ $goal }}" @checked(in_array($goal, $old('interests', [])))>
                                                    <span>{{ $goal }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <span class="zr-label">I am interested in</span>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach (['Buying a home' => 'house', 'Investment' => 'chart-line-up', 'Interior design' => 'armchair', 'A short stay' => 'bed', 'Corporate stays' => 'briefcase'] as $label => $icon)
                                            <label class="zr-choice">
                                                <input type="checkbox" name="interests[]" value="{{ $label }}" @checked(in_array($label, $old('interests', [])))>
                                                <span><i class="ph-duotone ph-{{ $icon }}"></i>{{ $label }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <label class="block mt-4"><span class="zr-label">Indicative budget</span>
                                        <select name="budget" class="zr-input">
                                            <option value="">Prefer to discuss</option>
                                            @foreach (['Under 50k', '50k – 150k', '150k – 500k', '500k – 1m', 'Over 1m'] as $b)
                                                @php($bv = config('grei.currency.symbol').$b)
                                                <option @selected($old('budget') === $bv)>{{ $bv }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                @endif
                                <label class="block mt-4"><span class="zr-label">{{ $for === 'list' ? 'Anything else we should know?' : 'Tell us a little more' }}</span>
                                    <textarea name="message" rows="4" required class="zr-input resize-none" placeholder="{{ $for === 'list' ? 'Size, condition, timing, current occupancy...' : 'Location, timing, style, or what you have in mind...' }}">{{ $old('message') }}</textarea>
                                </label>
                            </fieldset>

                            {{-- 3. Who --}}
                            <fieldset class="book-group">
                                <legend class="book-legend"><span>03</span>Your details</legend>
                                <label class="block"><span class="zr-label">Full name</span>
                                    <input name="name" required class="zr-input" value="{{ $old('name') }}" placeholder="Adaeze Okafor" autocomplete="name">
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                                    <label><span class="zr-label">Email address</span>
                                        <input type="email" name="email" required class="zr-input" value="{{ $old('email') }}" placeholder="you@company.com" autocomplete="email">
                                    </label>
                                    <label><span class="zr-label">Phone <span class="text-[#A3A3A3] font-normal">(optional)</span></span>
                                        <input type="tel" name="phone" class="zr-input" value="{{ $old('phone') }}" placeholder="+234 800 000 0000" autocomplete="tel">
                                    </label>
                                </div>
                            </fieldset>

                            <div class="pt-2 flex flex-col sm:flex-row sm:items-center gap-4 sm:justify-between">
                                <p class="text-[12px] text-[#8A8A8A] flex items-center gap-2"><i class="ph-duotone ph-shield-check text-[16px]"></i>No obligation. We reply within one working day.</p>
                                <button type="submit" class="zr-btn-hero">{{ $t['submit'] }}<i class="ph-duotone ph-arrow-right text-[14px] ml-2"></i></button>
                            </div>
                        </form>
                    @endif

                    {{-- Direct contact --}}
                    <div class="mt-14 pt-8 border-t border-[#EFEFEF] grid grid-cols-1 sm:grid-cols-3 gap-6 text-[13px]">
                        <div class="flex gap-3"><i class="ph-duotone ph-envelope-simple text-[18px] text-[#8C8C8C]"></i><span><span class="block text-[11px] text-[#8A8A8A]">Email</span><a class="hover:underline" href="mailto:{{ config('grei.contact.email') }}">{{ config('grei.contact.email') }}</a></span></div>
                        <div class="flex gap-3"><i class="ph-duotone ph-phone text-[18px] text-[#8C8C8C]"></i><span><span class="block text-[11px] text-[#8A8A8A]">Phone</span>{{ config('grei.contact.phone') }}</span></div>
                        <div class="flex gap-3"><i class="ph-duotone ph-clock text-[18px] text-[#8C8C8C]"></i><span><span class="block text-[11px] text-[#8A8A8A]">Hours</span>{{ config('grei.contact.hours') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
