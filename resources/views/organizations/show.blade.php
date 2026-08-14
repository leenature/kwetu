@extends('layouts.app')

@section('title', $organization->name)

@section('content')
<div class="properties-page organization-page">
    <header class="module-header">
        <div>
            <a href="{{ route('organizations.index') }}" class="back-link"><i class="bi bi-arrow-left"></i> Organizations</a>
            <p class="module-eyebrow mt-3">Customer account</p>
            <h1 class="module-title">{{ $organization->name }}</h1>
            <p class="module-subtitle">Created {{ $organization->created_at->format('d M Y') }} · {{ $organization->email ?: 'No organization email' }}</p>
        </div>
        <a href="{{ route('organizations.edit', $organization) }}" class="btn btn-primary px-3 py-2"><i class="bi bi-pencil-square me-1"></i> Manage subscription</a>
    </header>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-4"><div class="module-card property-summary"><span class="property-summary-icon summary-blue"><i class="bi bi-box-seam-fill"></i></span><div><small>SELECTED PLAN</small><strong>{{ ucfirst($organization->plan) }}</strong></div></div></div>
        <div class="col-md-4"><div class="module-card property-summary"><span class="property-summary-icon summary-green"><i class="bi bi-credit-card-fill"></i></span><div><small>SUBSCRIPTION</small><strong>{{ ucfirst($organization->subscription_status) }}</strong></div></div></div>
        <div class="col-md-4"><div class="module-card property-summary"><span class="property-summary-icon summary-purple"><i class="bi bi-buildings-fill"></i></span><div><small>PROPERTIES</small><strong>{{ number_format($organization->properties_count) }}</strong></div></div></div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="module-card h-100">
                <h5 class="mb-4">Account details</h5>
                <dl class="details-list">
                    <div><dt>Account status</dt><dd>{{ $organization->status }}</dd></div>
                    <div><dt>Trial ends</dt><dd>{{ $organization->trial_ends_at?->format('d M Y') ?? 'Not set' }}</dd></div>
                    <div><dt>Phone</dt><dd>{{ $organization->phone ?: 'Not provided' }}</dd></div>
                    <div><dt>Location</dt><dd>{{ collect([$organization->city, $organization->country])->filter()->join(', ') ?: 'Not provided' }}</dd></div>
                </dl>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="module-card h-100">
                <h5 class="mb-3">Users</h5>
                @forelse($organization->users as $user)
                    <div class="user-row">
                        <span class="user-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        <div><strong>{{ $user->name }}</strong><small>{{ $user->email }}</small></div>
                        <span class="ms-auto role-label">{{ $user->role }}</span>
                    </div>
                @empty
                    <p class="text-secondary mb-0">No users are assigned to this organization.</p>
                @endforelse
            </div>
        </div>
        <div class="col-12">
            <div class="module-card organization-table-card">
                <h5 class="mb-3">Portfolio</h5>
                <div class="table-responsive">
                    <table class="table modern-table align-middle mb-0">
                        <thead><tr><th>Property</th><th>Location</th><th>Type</th><th>Units</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($organization->properties as $property)
                                <tr><td class="fw-semibold">{{ $property->name }}</td><td>{{ collect([$property->town, $property->county])->filter()->join(', ') }}</td><td>{{ $property->type }}</td><td>{{ $property->units_count }}</td><td>{{ $property->status }}</td></tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-5 text-secondary">No properties have been added.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
