@props(['variant' => 'default', 'size' => 'h-8', 'showText' => true])

@php
$logoSrc = match($variant) {
    'nobg' => asset('images/logo-nobg.png'),
    'transparent' => asset('images/logo-nobg.png'),
    default => asset('images/logo.png'),
};
@endphp

<div class="flex items-center">
    <img class="{{ $size }} w-auto" src="{{ $logoSrc }}" alt="YuAUCT">
    @if($showText)
        <span class="ml-2 text-xl font-bold">YuAUCT</span>
    @endif
</div>
