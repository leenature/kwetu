@props([

'title',

'value',

'icon',

'color'=>'primary'

])

<div class="hero-pill">

    <div class="hero-pill-icon {{ $color }}">

        <i class="bi {{ $icon }}"></i>

    </div>

    <div>

        <small>{{ $title }}</small>

        <h5>{{ $value }}</h5>

    </div>

</div>