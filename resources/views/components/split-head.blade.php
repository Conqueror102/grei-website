@props(['title', 'h' => 'h2'])
{{-- Zenith "Section Header Split" --}}
<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-10 md:mb-12']) }}>
    <{{ $h }} class="text-[clamp(1.85rem,3.1vw,2.75rem)] font-normal leading-[1.12] tracking-[-0.03em] text-[#111111] max-w-[560px]">{!! $title !!}</{{ $h }}>
    <div class="md:max-w-[300px] md:pt-1" data-reveal>
        <div class="text-[13px] leading-[1.6] text-[#737373]">{{ $slot }}</div>
        {{ $after ?? '' }}
    </div>
</div>
