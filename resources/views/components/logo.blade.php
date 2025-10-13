@if($variant === 'nobg')
    <img src="{{ asset('images/logo-nobg.png') }}" alt="{{ config('app.name') }}" class="{{ $size }}">
@else
    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="{{ $size }}">
@endif

@if($showText)
    <span class="ml-2 text-xl font-bold text-white">{{ config('app.name') }}</span>
@endif