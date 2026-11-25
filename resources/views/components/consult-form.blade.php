@props(['intro' => null, 'topic' => null, 'type' => 'general', 'subjectId' => null, 'listing' => false, 'date' => true, 'submit' => 'Confirm Request', 'cancel' => true, 'message' => null, 'messageLabel' => 'Preferences'])
{{-- Zenith ConsultationModal form, posting to Laravel --}}
<form method="POST" action="{{ route('enquiries.store') }}" class="space-y-4">
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">
    @if ($subjectId)<input type="hidden" name="subject_id" value="{{ $subjectId }}">@endif
    @if ($topic)<input type="hidden" name="topic" value="{{ $topic }}">@endif
    <div class="hidden" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>

    @if ($intro)
        <p class="text-[13px] text-[#6E6E6E] leading-[1.55]">{{ $intro }}</p>
    @endif

    @if ($errors->any() && old('topic') === $topic)
        <div class="text-[12px] text-red-700 bg-red-50 border border-red-200 px-3 py-2">{{ $errors->first() }}</div>
    @endif

    <div>
        <label class="zr-label">Full Name</label>
        <input type="text" name="name" required value="{{ old('topic') === $topic ? old('name') : '' }}" placeholder="Adaeze Okafor" class="zr-input" autocomplete="name">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="zr-label">Email Address</label>
            <input type="email" name="email" required value="{{ old('topic') === $topic ? old('email') : '' }}" placeholder="you@company.com" class="zr-input" autocomplete="email">
        </div>
        @if ($date)
            <div>
                <label class="zr-label">Preferred Date</label>
                <input type="date" name="preferred_date" min="{{ now()->toDateString() }}" value="{{ now()->addDays(2)->toDateString() }}" class="zr-input">
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 {{ $listing || $type === 'interior' ? 'sm:grid-cols-2' : '' }} gap-4">
        <div>
            <label class="zr-label">Phone (Optional)</label>
            <input type="tel" name="phone" placeholder="+234 800 000 0000" class="zr-input" autocomplete="tel">
        </div>
        @if ($listing)
            <div>
                <label class="zr-label">Property Type</label>
                <select name="property_type" class="zr-input">
                    <option>Residential</option><option>Commercial</option><option>Land</option><option>Short-stay apartment</option>
                </select>
            </div>
        @elseif ($type === 'interior')
            <div>
                <label class="zr-label">Indicative Budget</label>
                <select name="budget" class="zr-input">
                    <option value="">Prefer to discuss</option>
                    @foreach (['Under 50k', '50k – 150k', '150k – 500k', 'Over 500k'] as $b)
                        <option>{{ config('grei.currency.symbol') }}{{ $b }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    <div>
        <label class="zr-label">{{ $listing ? 'About the Property' : $messageLabel }}</label>
        <textarea name="message" rows="3" required class="zr-input resize-none" placeholder="{{ $listing ? 'Location, size, and whether you want to sell, let or place it in GREI Stays...' : 'Location, budget, timing, or what you have in mind...' }}">{{ $message }}</textarea>
    </div>

    <div class="pt-2 flex justify-end gap-3">
        @if ($cancel)
            <button type="button" data-close-modal class="px-4 py-2.5 text-[12px] font-medium text-[#525252] hover:text-[#111111] cursor-pointer">Cancel</button>
        @endif
        <button type="submit" class="zr-btn-dark">{{ $submit }}</button>
    </div>
</form>
