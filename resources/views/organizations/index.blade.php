@extends('layouts.app')

@section('title', 'Organizations')

@section('content')
<div class="properties-page organization-page">
    <header class="module-header">
        <div>
            <p class="module-eyebrow">Super Admin</p>
            <h1 class="module-title">Organizations</h1>
            <p class="module-subtitle">Monitor customers, portfolios, free trials, and subscription plans.</p>
        </div>
        <span class="admin-label"><i class="bi bi-shield-lock-fill"></i> Super Admin only</span>
    </header>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="module-card organization-table-card">
        <div class="table-responsive">
            <table class="table modern-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>Owner</th>
                        <th>Plan</th>
                        <th>Subscription</th>
                        <th>Portfolio</th>
                        <th>Trial ends</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($organizations as $organization)
                        <tr>
                            <td>
                                <a class="fw-semibold text-decoration-none" href="{{ route('organizations.show', $organization) }}">{{ $organization->name }}</a>
                                <small class="d-block text-secondary">{{ $organization->email ?: 'No organization email' }}</small>
                            </td>
                            <td>
                                {{ $organization->users->first()?->name ?? 'No owner assigned' }}
                                <small class="d-block text-secondary">{{ $organization->users->first()?->email }}</small>
                            </td>
                            <td><span class="plan-badge plan-{{ $organization->plan }}">{{ ucfirst($organization->plan) }}</span></td>
                            <td><span class="status-badge status-{{ $organization->subscription_status }}">{{ ucfirst($organization->subscription_status) }}</span></td>
                            <td>{{ number_format($organization->properties_count) }} properties · {{ number_format($organization->tenants_count) }} tenants</td>
                            <td>{{ $organization->trial_ends_at?->format('d M Y') ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('organizations.show', $organization) }}" class="btn btn-sm btn-light border">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-5 text-secondary">No customer organizations yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($organizations->hasPages())
            <div class="pt-4">{{ $organizations->links() }}</div>
        @endif
    </div>
</div>
@endsection
