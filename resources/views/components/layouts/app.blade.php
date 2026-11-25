@props(['title' => null, 'description' => null, 'confirm' => true])
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ? $title.' — ' : '' }}GREI Group — Global Real Estate &amp; Interior Design</title>
    <meta name="description" content="{{ $description ?? 'Discover real estate, transform interiors and experience premium stays with GREI Group. '.config('grei.purpose') }}" />
    <meta property="og:title" content="{{ $title ?? 'GREI Group' }}" />
    <meta property="og:description" content="{{ $description ?? config('grei.purpose') }}" />
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400..700;1,9..40,400..700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    {{-- Turn on reveal animations before first paint; undo if the script never loads. --}}
    <script>document.documentElement.classList.add('gr-motion');setTimeout(function(){if(!window.__grMotion)document.documentElement.classList.remove('gr-motion')},2500);</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#111111] antialiased selection:bg-[#111111] selection:text-white">
    <div class="min-h-screen bg-white text-[#111111] flex flex-col">
        <x-navbar />
        <main class="flex-1">
            {{ $slot }}
        </main>
        <x-footer />
    </div>

    {{-- Site-wide modals, as in Zenith --}}
    <x-modal id="modal-call" title="Book a Private Advisory Call" max="max-w-lg">
        <x-consult-form intro="Speak directly with a GREI advisor about property, interiors or a stay. We'll confirm a time by email." topic="Advisory call" />
    </x-modal>
    <x-modal id="modal-consult" title="Free Design &amp; Property Consult" max="max-w-lg">
        <x-consult-form intro="Receive a bespoke shortlist of vetted properties, interior concepts or stays, prepared by a GREI consultant." topic="Free consult" />
    </x-modal>
    <x-modal id="modal-list" title="List a Property with GREI" max="max-w-lg">
        <x-consult-form intro="Selling, letting, or placing your home into GREI Stays? Tell us about it and an advisor will arrange a valuation." topic="List a property" type="general" :listing="true" submit="Submit Property" />
    </x-modal>

    @if ($confirm && session('enquiry_sent'))
        <x-modal id="modal-confirmed" title="Request Confirmed" max="max-w-lg" :autoshow="true">
            <div class="py-6 text-center space-y-4">
                <div class="w-10 h-10 bg-[#111111] text-white mx-auto flex items-center justify-center rounded-[2px]">
                    <i class="ph-duotone ph-check text-[20px]"></i>
                </div>
                <h4 class="text-[18px] font-medium text-[#111111]">Request Confirmed</h4>
                <p class="text-[13px] leading-[1.6] text-[#6E6E6E] max-w-sm mx-auto">
                    Thank you. A GREI advisor will reach out within one working day.
                </p>
                <button type="button" data-close-modal class="mt-2 inline-flex items-center justify-center bg-[#111111] hover:bg-[#262626] text-white text-[12px] font-medium px-6 py-2.5 rounded-[2px] cursor-pointer">Done</button>
            </div>
        </x-modal>
    @endif
</body>
</html>
