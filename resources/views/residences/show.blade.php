@extends('layouts.marketplace')

@section('title', $property->name)

@section('content')
    @php($amenities = $property->amenities ?? [])
    <main class="residence-detail">
        <section class="residence-hero">
            <div class="residence-shell">
                <a class="text-white text-decoration-none small" href="{{ route('residences.index') }}"><i class="bi bi-arrow-left"></i> Back to all residences</a>
                <h1 class="mt-3">{{ $property->name }}</h1>
                <p><i class="bi bi-geo-alt-fill"></i> {{ $property->address }}, {{ $property->town }}, {{ $property->county }}</p>
            </div>
        </section>

        <div class="residence-shell py-5">
            <div class="row g-4">
                <div class="col-lg-8">
                    <section class="residence-content-card mb-4">
                        <h2>About this residence</h2>
                        <p>{{ $property->description ?: 'A verified property with vacant spaces ready for your viewing.' }}</p>
                        <h3 class="mt-4">Amenities</h3>
                        @forelse($amenities as $amenity)
                            <span class="amenity-chip"><i class="bi bi-check2"></i> {{ $amenity }}</span>
                        @empty
                            <p class="text-muted">Ask the owner for the full amenity list.</p>
                        @endforelse
                    </section>

                    <section class="residence-content-card">
                        <h2>Vacant spaces</h2>
                        <p class="text-muted">Choose a unit, then call the contact below to arrange a viewing.</p>
                        <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Unit</th><th>Type</th><th>Details</th><th class="text-end">Monthly rent</th></tr></thead><tbody>
                            @foreach($property->units as $unit)
                                <tr><td>{{ $unit->unit_number }}</td><td>{{ $unit->unit_type }}</td><td>{{ $unit->bedrooms }} bed · {{ $unit->bathrooms }} bath</td><td class="text-end fw-bold">KSh {{ number_format($unit->monthly_rent, 0) }}</td></tr>
                            @endforeach
                        </tbody></table></div>
                    </section>
                </div>

                <aside class="col-lg-4">
                    @if($property->latitude && $property->longitude)
                        <iframe class="residence-map shadow-sm mb-3" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="https://www.openstreetmap.org/export/embed.html?bbox={{ $property->longitude - 0.01 }}%2C{{ $property->latitude - 0.01 }}%2C{{ $property->longitude + 0.01 }}%2C{{ $property->latitude + 0.01 }}&layer=mapnik&marker={{ $property->latitude }}%2C{{ $property->longitude }}"></iframe>
                        <button type="button" id="routePlanner" class="btn btn-outline-primary w-100 route-button justify-content-center mb-3" data-lat="{{ $property->latitude }}" data-lng="{{ $property->longitude }}"><i class="bi bi-sign-turn-right"></i> Show directions here</button>
                        <div id="routeResult" class="route-result mb-4" aria-live="polite">Tap “Show directions here” and allow location access to see your travel distance and estimated drive time.</div>
                    @endif

                    <section class="contact-panel">
                        <h3>Contact the owner</h3>
                        <p class="small">Call or email to arrange a viewing.</p>
                        <strong>{{ $property->client?->name ?? 'Property manager' }}</strong>
                        @if($property->client?->phone)
                            <a class="d-block mt-2 text-decoration-none" href="tel:{{ $property->client->phone }}"><i class="bi bi-telephone"></i> {{ $property->client->phone }}</a>
                        @endif
                        @if($property->client?->email)
                            <a class="d-block mt-2 text-decoration-none" href="mailto:{{ $property->client->email }}"><i class="bi bi-envelope"></i> Email contact</a>
                        @endif
                    </section>
                </aside>
            </div>

            @if($recommendations->isNotEmpty())
                <section class="mt-5"><h2 class="mb-4">Similar places you may like</h2><div class="row g-4">
                    @foreach($recommendations as $recommendation)
                        <div class="col-md-4"><article class="residence-card"><div class="residence-card-body"><h3>{{ $recommendation->name }}</h3><p>{{ $recommendation->town }} · {{ $recommendation->type }}</p><strong>From KSh {{ number_format($recommendation->units->min('monthly_rent'), 0) }}</strong><a href="{{ route('residences.show', $recommendation) }}" class="btn btn-outline-primary w-100 mt-3">View residence</a></div></article></div>
                    @endforeach
                </div></section>
            @endif
        </div>
    </main>
@endsection
