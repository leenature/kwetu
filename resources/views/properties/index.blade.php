@extends('layouts.app')

@section('title', 'Properties')

@section('content')

<div class="properties-page">
    <header class="module-header">
        <div>
            <p class="module-eyebrow">Portfolio management</p>
            <h1 class="module-title">Properties</h1>
            <p class="module-subtitle">Manage your property portfolio, locations, and availability.</p>
        </div>

        <a href="{{ route('properties.create') }}" class="btn btn-primary px-3 py-2">
            <i class="bi bi-plus-lg me-1"></i>
            Add Property
        </a>
    </header>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}

            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="module-card property-summary">
                <span class="property-summary-icon summary-blue">
                    <i class="bi bi-buildings-fill"></i>
                </span>
                <div>
                    <small>TOTAL PROPERTIES</small>
                    <strong>{{ $properties->total() }}</strong>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="module-card property-summary">
                <span class="property-summary-icon summary-green">
                    <i class="bi bi-check-circle-fill"></i>
                </span>
                <div>
                    <small>ACTIVE</small>
                    <strong>{{ $properties->where('status', 'Active')->count() }}</strong>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="module-card property-summary">
                <span class="property-summary-icon summary-red">
                    <i class="bi bi-pause-circle-fill"></i>
                </span>
                <div>
                    <small>INACTIVE</small>
                    <strong>{{ $properties->where('status', 'Inactive')->count() }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="module-card mb-4">
        <form method="GET" class="module-toolbar">
            <div class="module-search">
                <i class="bi bi-search"></i>
                <input type="search"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Search by property, code, town, or county">
            </div>

            <button class="btn btn-dark px-4" type="submit">
                Search
            </button>

            @if(request('search'))
                <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div class="module-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table properties-table align-middle">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($properties as $property)
                        <tr>
                            <td>
                                <span class="property-code">{{ $property->code }}</span>
                                <span class="property-name">{{ $property->name }}</span>
                                <span class="badge {{ $property->verification_status === 'Verified' ? 'text-bg-success' : ($property->verification_status === 'Rejected' ? 'text-bg-danger' : 'text-bg-warning') }} ms-1">{{ $property->verification_status === 'Verified' ? 'Verified' : $property->verification_status }}</span>
                            </td>

                            <td>{{ $property->type }}</td>

                            <td>
                                <span class="property-name">{{ $property->town }}</span>
                                <span class="property-location">{{ $property->county }}</span>
                            </td>

                            <td>
                                <span class="status-pill {{ $property->status === 'Active' ? 'status-active' : 'status-inactive' }}">
                                    {{ $property->status }}
                                </span>
                            </td>

                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('properties.show', $property) }}"
                                       class="table-action action-view"
                                       aria-label="View {{ $property->name }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <a href="{{ route('properties.edit', $property) }}"
                                       class="table-action action-edit"
                                       aria-label="Edit {{ $property->name }}">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <form action="{{ route('properties.destroy', $property) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="table-action action-delete"
                                                aria-label="Delete {{ $property->name }}"
                                                onclick="return confirm('Delete {{ $property->name }}?')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="bi bi-buildings"></i>
                                <strong class="d-block">No properties found</strong>
                                <span class="text-muted">Add your first property to begin managing your portfolio.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $properties->withQueryString()->links() }}
    </div>
</div>

@endsection
