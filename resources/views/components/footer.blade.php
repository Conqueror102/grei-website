@php
    // Zenith's footer settings, unchanged: grey palette, seed 23, 7 ridges.
    $tones = ['#F5F5F5', '#E3E3E3', '#C9C9C9', '#9E9E9E', '#6E6E6E', '#3D3D3D', '#171717'];
    $columns = [
        'Real Estate' => [
            ['Residential', route('real-estate.index', ['category' => 'residential'])],
            ['Commercial', route('real-estate.index', ['category' => 'commercial'])],
            ['Investment', route('real-estate.index', ['type' => 'investment'])],
            ['All Properties', route('real-estate.index')],
        ],
        'Interiors & Stays' => [
            ['Interior Services', route('interiors.index')],
            ['Portfolio', route('interiors.index').'#portfolio'],
            ['Short Stays', route('stays.index'), 'New'],
            ['List a Property', '#', null, 'modal-list'],
        ],
        'Company' => [
            ['About GREI', route('about')],
            ['Book a Call', '#', null, 'modal-call'],
            ['Contact', route('contact')],
        ],
    ];
@endphp
<footer data-ridgeline data-seed="23" data-ridges="7" data-pixel="2" data-tones='@json($tones)'
        class="rdf-root"
        style="min-height:640px; --rdf-scene-min:280px; --rdf-paper:#F5F5F5; --rdf-ink:#111111; --rdf-muted:#737373; --rdf-line:#E2E2E2; --rdf-heart:#111111; --rdf-deep:#3D3D3D; --rdf-accent:#6E6E6E; --rdf-n:{{ count($columns) }}; --rdf-max:1320px; --rdf-sans:'DM Sans', 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif; --rdf-mono:'JetBrains Mono', 'SF Mono', ui-monospace, Menlo, Consolas, monospace;">
    <div class="rdf-frame">
        <div class="rdf-top">
            <div class="rdf-brand">
                <a class="rdf-logo rdf-r" style="--d:140" href="{{ route('home') }}">
                    <img src="{{ asset('images/brand/grei-mark-dark-tight.png') }}" alt="" style="height:30px;width:auto">
                    <span>GREI Group</span>
                </a>
                <p class="rdf-tag rdf-r" style="--d:230">{{ config('grei.purpose') }} Real estate, interiors and premium stays.</p>
                <ul class="rdf-social">
                    <li class="rdf-r" style="--d:320"><a href="{{ config('grei.socials.instagram') }}" aria-label="GREI on Instagram"><i class="ph-duotone ph-instagram-logo" style="font-size:16px"></i></a></li>
                    <li class="rdf-r" style="--d:380"><a href="{{ config('grei.socials.linkedin') }}" aria-label="GREI on LinkedIn"><i class="ph-duotone ph-linkedin-logo" style="font-size:16px"></i></a></li>
                    <li class="rdf-r" style="--d:440"><a href="mailto:{{ config('grei.contact.email') }}" aria-label="Email GREI"><i class="ph-duotone ph-envelope-simple" style="font-size:16px"></i></a></li>
                </ul>
            </div>
            @foreach ($columns as $title => $links)
                <nav class="rdf-col" aria-label="{{ $title }}">
                    <h3 class="rdf-r" style="--d:{{ 260 + $loop->index * 110 }}">{{ $title }}</h3>
                    <ul>
                        @foreach ($links as $li => $l)
                            <li class="rdf-r" style="--d:{{ 330 + $loop->parent->index * 110 + $li * 55 }}">
                                <a class="rdf-link" href="{{ $l[1] }}" @if(!empty($l[3])) data-open-modal="{{ $l[3] }}" @endif>
                                    {{ $l[0] }}
                                    @if (!empty($l[2]))<span class="rdf-badge">{{ $l[2] }}</span>@endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            @endforeach
        </div>
        <div class="rdf-bar rdf-r" style="--d:1250">
            <p>© {{ date('Y') }} GREI Group. All rights reserved.</p>
        </div>
        <div class="rdf-scene">
            <canvas aria-hidden="true"></canvas>
            <div class="rdf-alt" aria-hidden="true"><b></b><i></i><span></span></div>
        </div>
    </div>
</footer>
