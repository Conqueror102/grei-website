@props(['src', 'alt' => '', 'w' => 1600, 'eager' => false])
@php($remote = \App\Support\Img::isRemote($src))
<img src="{{ \App\Support\Img::url($src, $w) }}" alt="{{ $alt }}" loading="{{ $eager ? 'eager' : 'lazy' }}" decoding="async"
     @if($remote) data-fallback="{{ \App\Support\Img::fallback($src) }}" referrerpolicy="no-referrer" @endif
     {{ $attributes }}>
