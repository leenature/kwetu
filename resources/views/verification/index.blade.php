@extends('layouts.app')

@section('title', 'Property Verification')

@section('content')
<div class="properties-page">
    <header class="module-header"><div><p class="module-eyebrow">Trust and safety</p><h1 class="module-title">Property verification</h1><p class="module-subtitle">Review submitted location evidence, photos, and management documents before approving a property.</p></div></header>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div class="module-card organization-table-card"><div class="table-responsive"><table class="table modern-table align-middle mb-0"><thead><tr><th>Property</th><th>Owner organization</th><th>Evidence</th><th>Current status</th><th>Decision</th></tr></thead><tbody>
    @forelse($properties as $property)
        <tr><td><a href="{{ route('properties.show', $property) }}" class="fw-semibold text-decoration-none">{{ $property->name }}</a><small class="d-block text-secondary">{{ $property->town }}, {{ $property->county }}</small></td><td>{{ $property->organization?->name }}</td><td>{{ $property->files->count() }} uploads</td><td>{{ $property->verification_status }}</td><td><form action="{{ route('verification.update', $property) }}" method="POST" class="d-grid gap-2">@csrf @method('PATCH')<select name="verification_status" class="form-select form-select-sm"><option @selected($property->verification_status === 'Pending Review')>Pending Review</option><option @selected($property->verification_status === 'Verified')>Verified</option><option @selected($property->verification_status === 'Rejected')>Rejected</option></select><input class="form-control form-control-sm" name="verification_notes" placeholder="Reason or review note" value="{{ $property->verification_notes }}"><button class="btn btn-sm btn-primary">Save decision</button></form></td></tr>
    @empty<tr><td colspan="5" class="text-center py-5 text-secondary">No properties submitted for verification.</td></tr>@endforelse
    </tbody></table></div>{{ $properties->links() }}</div>
</div>
@endsection
