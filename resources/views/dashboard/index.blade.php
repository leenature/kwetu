
@extends('layouts.app')

@section('title','Dashboard')
@section('page-styles')
    @vite('resources/css/dashboard.css')
@endsection

@section('page-scripts')
    @vite('resources/js/dashboard.js')
@endsection

@section('content')

<link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">








    <!-- Statistics -->
  <div class="dashboard-container">

    {{-- ================= HERO ================= --}}
    <div class="row mb-4">

        <div class="col-12">

            <div class="hero-dashboard">

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
                                {{ $occupancyRate }}%
                            </h2>

                            <span>Healthy occupancy</span>
                        </div>

                        <div class="hero-stat">
                            <small>Collected</small>

                            <h2>
                                KSh {{ number_format($collectedThisMonth) }}
                            </h2>

                            <span>Monthly Revenue</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- ================= KPI CARDS ================= --}}

   <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-5 g-4 mb-5 kpi-row">

        <!-- Properties -->
        <div class="col">

            <div class="glass-card stat-card">

                <div class="icon blue">
                    <i class="bi bi-buildings"></i>
                </div>

                <div class="stat-content">

                    <div class="stat-header">

                        <div>
                            <small class="card-title">PROPERTIES</small>
                        </div>

                        <span class="status live">
                            <span class="dot"></span>
                            LIVE
                        </span>

                    </div>

                    <h2 class="counter" data-target="{{ $properties }}">
                        0
                    </h2>

                    <div class="trend up">
                        <i class="bi bi-arrow-up"></i>
                        {{ $properties }} registered properties
                    </div>

                    <canvas id="spark-properties" class="sparkline"></canvas>

                </div>

            </div>

        </div>



        <!-- Total Units -->
        <div class="col">

            <div class="glass-card stat-card">

                <div class="icon blue">
                    <i class="bi bi-door-open-fill"></i>
                </div>

                <div class="stat-content">

                    <div class="stat-header">

                        <div>
                            <small class="card-title">TOTAL UNITS</small>
                        </div>

                        <span class="status live">
                            <span class="dot"></span>
                            LIVE
                        </span>

                    </div>

                    <h2 class="counter" data-target="{{ $units }}">
                        0
                    </h2>

                    <div class="trend up">
                        <i class="bi bi-arrow-up"></i>
                        {{ $occupiedUnits }} occupied units
                    </div>

                    <canvas id="spark-units" class="sparkline"></canvas>

                </div>

            </div>

        </div>



        <!-- Tenants -->
        <div class="col">

            <div class="glass-card stat-card">

                <div class="icon purple">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="stat-content">

                    <div class="stat-header">

                        <div>
                            <small class="card-title">TENANTS</small>
                        </div>

                        <span class="status live">
                            <span class="dot"></span>
                            ACTIVE
                        </span>

                    </div>

                    <h2 class="counter" data-target="{{ $tenants }}">
                        0
                    </h2>

                    <div class="trend up">
                        <i class="bi bi-arrow-up"></i>
                        {{ $tenants }} active tenant records
                    </div>

                    <canvas id="spark-tenants" class="sparkline"></canvas>

                </div>

            </div>

        </div>



        <!-- Occupied -->
        <div class="col">

            <div class="glass-card stat-card">

                <div class="icon green">
                    <i class="bi bi-person-check-fill"></i>
                </div>

                <div class="stat-content">

                    <div class="stat-header">

                        <div>
                            <small class="card-title">OCCUPIED</small>
                        </div>

                        <span class="status live">
                            <span class="dot"></span>
                            HEALTHY
                        </span>

                    </div>

                    <h2 class="counter" data-target="{{ $occupiedUnits }}">
                        0
                    </h2>

                    <div class="trend up">
                        <i class="bi bi-arrow-up"></i>
                        {{ $occupancyRate }}% of all units
                    </div>

                    <canvas id="spark-occupied" class="sparkline"></canvas>

                </div>

            </div>

        </div>



        <!-- Vacant -->
        <div class="col">

            <div class="glass-card stat-card">

                <div class="icon red">
                    <i class="bi bi-house-slash-fill"></i>
                </div>

                <div class="stat-content">

                    <div class="stat-header">

                        <div>
                            <small class="card-title">VACANT</small>
                        </div>

                        <span class="status live">
                            <span class="dot"></span>
                            WARNING
                        </span>

                    </div>

                    <h2 class="counter" data-target="{{ $vacantUnits }}">
                        0
                    </h2>

                    <div class="trend down">
                        <i class="bi bi-arrow-down"></i>
                        {{ $vacantUnits }} units awaiting tenants
                    </div>

                    <canvas id="spark-vacant" class="sparkline"></canvas>

                </div>

            </div>

        </div>

    </div>

    {{-- ================= FINANCE CARDS START HERE ================= --}}

{{-- ================= FINANCIAL SUMMARY ================= --}}
<div class="row row-cols-1 row-cols-md-3 g-4 mb-5 finance-row">

    <!-- Expected Rent -->
    <div class="col">

        <div class="glass-card finance-card">

            <div class="finance-icon income">
                <i class="bi bi-wallet2"></i>
            </div>

            <div class="finance-content">

                <small>EXPECTED RENT</small>

                <h2 class="counter money-counter"
                    data-target="{{ $expectedRent }}">
                    KSh 0
                </h2>

                <div class="trend up">
                    <i class="bi bi-graph-up-arrow"></i>
                    Monthly Target
                </div>

            </div>

        </div>

    </div>

    <!-- Collected -->
    <div class="col">

        <div class="glass-card finance-card">

            <div class="finance-icon collected">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div class="finance-content">

                <small>COLLECTED</small>

                <h2 class="counter money-counter"
                    data-target="{{ $collectedThisMonth }}">
                    KSh 0
                </h2>

                <div class="trend up">
                    <i class="bi bi-check-circle-fill"></i>
                    This Month
                </div>

            </div>

        </div>

    </div>

    <!-- Outstanding -->
    <div class="col">

        <div class="glass-card finance-card">

            <div class="finance-icon outstanding">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <div class="finance-content">

                <small>OUTSTANDING</small>

                <h2 class="counter money-counter text-danger"
                    data-target="{{ $outstanding }}">
                    KSh 0
                </h2>

                <div class="trend down">
                    <i class="bi bi-arrow-down"></i>
                    Pending Collection
                </div>

            </div>

        </div>

    </div>

</div>



@if($isSuperAdmin)
<div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
    <div class="col"><div class="glass-card finance-card"><div class="finance-icon collected"><i class="bi bi-people-fill"></i></div><div class="finance-content"><small>ACTIVE SUBSCRIPTIONS</small><h2>{{ number_format($activeSubscriptions) }}</h2><div class="trend up">Trialing and active accounts</div></div></div></div>
    <div class="col"><div class="glass-card finance-card"><div class="finance-icon income"><i class="bi bi-cash-stack"></i></div><div class="finance-content"><small>EXPECTED MONTHLY PLAN REVENUE</small><h2>KSh {{ number_format($expectedSubscriptionRevenue) }}</h2><div class="trend up">Growth KSh 2,500 · Pro KSh 5,000</div></div></div></div>
    <div class="col"><div class="glass-card finance-card"><div class="finance-icon outstanding"><i class="bi bi-boxes"></i></div><div class="finance-content"><small>PACKAGE MIX</small><h2>{{ $subscriptionMetrics->get('starter', 0) }} / {{ $subscriptionMetrics->get('growth', 0) }} / {{ $subscriptionMetrics->get('pro', 0) }}</h2><div class="trend">Starter / Growth / Pro</div></div></div></div>
</div>
@endif

{{-- ================= OCCUPANCY + RECENT PAYMENTS ================= --}}
<div class="row g-4 mb-5 overview-row">

    <!-- Occupancy -->
    <div class="col-lg-5">

        <div class="glass-card">

            <div class="section-title">

                <div class="d-flex justify-content-between align-items-center">

                    <h4>
                        <i class="bi bi-pie-chart-fill"></i>
                        Occupancy
                    </h4>

                    <span class="badge rounded-pill bg-success-subtle text-success">
                        LIVE
                    </span>

                </div>

                <small>Property Occupancy Overview</small>

            </div>

            <div class="chart-box">

                <canvas id="occupancyChart"></canvas>

            </div>

            <div class="text-center mt-4">

                <h3 class="fw-bold">

                    {{ $occupiedUnits }}
                    /
                    {{ $units }}

                </h3>

                <p class="text-secondary mb-0">

                    Occupied Units

                </p>

            </div>

        </div>

    </div>



    <!-- Recent Payments -->
    <div class="col-lg-7">

        <div class="glass-card">

            <div class="section-title">

                <div class="d-flex justify-content-between align-items-center">

                    <h4>

                        <i class="bi bi-credit-card-2-front-fill"></i>

                        Recent Payments

                    </h4>

                    <span class="badge rounded-pill bg-primary-subtle text-primary">

                        Latest

                    </span>

                </div>

                <small>

                    Latest Rent Transactions

                </small>

            </div>

            <div class="table-responsive">

                <table class="table modern-table align-middle">

                    <thead>

                        <tr>

                            <th>Tenant</th>

                            <th>Amount</th>

                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($recentPayments as $payment)

                        <tr>

                            <td>

                                {{ $payment->lease->tenant->full_name ?? 'N/A' }}

                            </td>

                            <td class="fw-bold text-success">

                                KSh {{ number_format($payment->amount_paid) }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="3" class="text-center py-5">

                                No Payments Yet

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>



{{-- ================= FINANCIAL OVERVIEW ================= --}}
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="glass-card">
            <div class="section-title">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>
                        <i class="bi bi-graph-up-arrow"></i>
                        Revenue Analytics
                    </h4>

                    <span class="badge rounded-pill bg-info-subtle text-info">
                        This Year
                    </span>
                </div>

                <small>Monthly rent collection performance</small>
            </div>

            <div style="height: 360px; position: relative;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-12">

        <div class="glass-card">

            <div class="section-title">

                <div class="d-flex justify-content-between align-items-center">

                    <h4>

                        <i class="bi bi-bar-chart-line-fill"></i>

                        Financial Overview

                    </h4>

                    <span class="badge rounded-pill bg-warning-subtle text-warning">

                        LIVE ANALYTICS

                    </span>

                </div>

                <small>

                    Income vs Expenses vs Profit

                </small>

            </div>

            <div style="height:340px">

                <canvas id="financeChart"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="glass-card portfolio-map-card">
            <div class="section-title d-flex justify-content-between align-items-start gap-3">
                <div><h4><i class="bi bi-geo-alt-fill"></i> Portfolio map</h4><small>{{ $isSuperAdmin ? 'All registered properties across organizations.' : 'Your registered properties and their verified locations.' }}</small></div>
                <span class="badge rounded-pill bg-primary-subtle text-primary">{{ $mapProperties->count() }} mapped</span>
            </div>
            <div id="portfolioMap" aria-label="Portfolio map"></div>
            @if($mapProperties->isEmpty())<p class="map-empty">No property coordinates yet. Add a location pin when registering a property to see it here.</p>@endif
        </div>
    </div>
</div>

@if(false)
<div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
    <div class="col"><div class="glass-card finance-card"><div class="finance-icon collected"><i class="bi bi-people-fill"></i></div><div class="finance-content"><small>ACTIVE SUBSCRIPTIONS</small><h2>{{ number_format($activeSubscriptions) }}</h2><div class="trend up">Trialing and active accounts</div></div></div></div>
    <div class="col"><div class="glass-card finance-card"><div class="finance-icon income"><i class="bi bi-cash-stack"></i></div><div class="finance-content"><small>EXPECTED MONTHLY PLAN REVENUE</small><h2>KSh {{ number_format($expectedSubscriptionRevenue) }}</h2><div class="trend up">Growth KSh 2,500 · Pro KSh 5,000</div></div></div></div>
    <div class="col"><div class="glass-card finance-card"><div class="finance-icon outstanding"><i class="bi bi-boxes"></i></div><div class="finance-content"><small>PACKAGE MIX</small><h2>{{ $subscriptionMetrics->get('starter', 0) }} / {{ $subscriptionMetrics->get('growth', 0) }} / {{ $subscriptionMetrics->get('pro', 0) }}</h2><div class="trend">Starter / Growth / Pro</div></div></div></div>
</div>
@endif
@if($isSuperAdmin)
<div class="row g-4 mt-1 mb-5">
    <div class="col-12">
        <div class="glass-card subscription-overview">
            <div class="section-title d-flex justify-content-between align-items-start gap-3">
                <div>
                    <h4><i class="bi bi-credit-card-2-front-fill"></i> Subscription Overview</h4>
                    <small>Newest organizations and their selected Kwetu package.</small>
                </div>
                <span class="badge rounded-pill bg-danger-subtle text-danger">SUPER ADMIN</span>
            </div>

            <div class="table-responsive">
                <table class="table modern-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Organization</th>
                            <th>Owner</th>
                            <th>Package</th>
                            <th>Subscription</th>
                            <th>Properties</th>
                            <th>Trial ends</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptionOrganizations as $organization)
                            <tr>
                                <td class="fw-semibold">
                                    <a class="text-decoration-none" href="{{ route('organizations.show', $organization) }}">{{ $organization->name }}</a>
                                </td>
                                <td>
                                    {{ $organization->users->first()?->name ?? 'No owner assigned' }}
                                    <small class="d-block text-secondary">{{ $organization->users->first()?->email }}</small>
                                </td>
                                <td><span class="plan-badge plan-{{ $organization->plan }}">{{ ucfirst($organization->plan) }}</span></td>
                                <td><span class="status-badge status-{{ $organization->subscription_status }}">{{ ucfirst($organization->subscription_status) }}</span></td>
                                <td>{{ number_format($organization->properties_count) }}</td>
                                <td>{{ $organization->trial_ends_at?->format('d M Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-5 text-secondary">No customer organizations yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

</div>

{{-- Pass Laravel data to app.js --}}
<script>
window.dashboardData = {

    occupied: {{ $occupiedUnits }},
    vacant: {{ $vacantUnits }},

    months: @json($revenueMonths),
    revenue: @json($revenueValues),

    collected: {{ $collectedThisMonth }},
    expenses: {{ $totalExpenses }},
    profit: {{ $profit }}
    , occupancyRate: {{ $occupancyRate }}

};
window.mapProperties = @json($mapProperties);
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const map = L.map('portfolioMap').setView([-1.286389, 36.817223], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
    const markers = [];
    (window.mapProperties || []).forEach(property => {
        const marker = L.marker([property.latitude, property.longitude]).addTo(map);
        const popup = document.createElement('div');
        const name = document.createElement('strong');
        const location = document.createElement('div');
        const status = document.createElement('small');
        name.textContent = property.name;
        location.textContent = `${property.town}, ${property.county}`;
        status.textContent = property.status;
        popup.append(name, location, status);
        marker.bindPopup(popup);
        markers.push(marker);
    });
    if (markers.length) map.fitBounds(L.featureGroup(markers).getBounds().pad(0.2));
});
</script>



@endsection
