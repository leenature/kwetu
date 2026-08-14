@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Welcome back, {{ Auth::user()->name }}
</h2>

<!-- Hero -->
<div class="hero-dashboard mb-4">

    <div class="hero-content">

        <div class="hero-left">

            <span class="hero-badge">
                <i class="bi bi-stars"></i>
                Smart Property Management
            </span>

           <h1 class="d-flex align-items-center gap-2 fw-bold">
    Welcome back, {{ Auth::user()->name }}
    <i class="bi bi-stars text-warning"></i>
</h1>

            <p>
                Monitor your properties, tenants, occupancy and revenue
                from one intelligent dashboard.
            </p>

        </div>

        <div class="hero-right">

            <div class="hero-stat">

                <small>Total Properties</small>

                <h2>{{ $properties }}</h2>

                <span>Growing portfolio</span>

            </div>

            <div class="hero-stat">

                <small>Occupancy</small>

                <h2>
                    {{ $units > 0 ? round(($occupiedUnits/$units)*100) : 0 }}%
                </h2>

                <span>Healthy occupancy</span>

            </div>

            <div class="hero-stat">

                <small>Collected</small>

                <h2>KSh {{ number_format($collectedThisMonth) }}</h2>

                <span>Monthly revenue</span>

            </div>

        </div>

    </div>

</div>
@endsection