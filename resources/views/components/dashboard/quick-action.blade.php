@props([

'icon',

'title',

'route'=>'#'

])

<a href="{{ $route }}" class="hero-action">

    <i class="bi {{ $icon }}"></i>

    <span>{{ $title }}</span>

</a>