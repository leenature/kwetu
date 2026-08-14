@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                🏢 {{ $property->name }}
            </h2>

            <small class="text-muted">
                {{ $property->town }}, {{ $property->county }}
            </small>

        </div>

        <div>

            @if(auth()->user()->canAccessModule('maintenance'))
                <a href="{{ route('maintenance.index', ['property_id' => $property->id]) }}" class="btn btn-outline-primary">
                    <i class="bi bi-tools"></i> Maintenance
                </a>
            @endif

            <a href="{{ route('properties.edit',$property) }}"
               class="btn btn-warning">
                ✏ Edit
            </a>

            <a href="{{ route('units.create') }}?property={{ $property->id }}"
               class="btn btn-primary">
                ➕ Add Unit
            </a>

            <a href="{{ route('properties.index') }}"
               class="btn btn-secondary">
                ← Back
            </a>

        </div>

    </div>


    <!-- Statistics -->

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">Total Units</h6>

                    <h2 class="fw-bold">
                        {{ $totalUnits }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">Occupied</h6>

                    <h2 class="text-success fw-bold">
                        {{ $occupiedUnits }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">Vacant</h6>

                    <h2 class="text-warning fw-bold">
                        {{ $vacantUnits }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    <h6 class="text-muted">Expected Monthly Rent</h6>

                    <h4 class="fw-bold text-primary">
                        KSh {{ number_format($expectedRent,2) }}
                    </h4>

                </div>

            </div>

        </div>

    </div>


    <!-- Quick Navigation -->

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h5>🏢 Units</h5>

                    <p class="text-muted">
                        View and manage all units
                    </p>

                   <a href="{{ route('properties.units', $property) }}"
   class="btn btn-outline-primary btn-sm">
    Open Units
</a>
                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h5>👥 Tenants</h5>

                    <p class="text-muted">
                        Manage tenants
                    </p>

                    <a href="{{ route('tenants.index') }}"
                       class="btn btn-outline-success btn-sm">

                        Open Tenants

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h5>📑 Leases</h5>

                    <p class="text-muted">
                        Lease agreements
                    </p>

                    <a href="{{ route('leases.index') }}"
                       class="btn btn-outline-warning btn-sm">

                        Open Leases

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <h5>💰 Payments</h5>

                    <p class="text-muted">
                        Rent payments
                    </p>

                    <a href="{{ route('payments.index') }}"
                       class="btn btn-outline-dark btn-sm">

                        Open Payments

                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- Property Information -->

    <div class="card shadow-sm mb-4">

        <div class="card-header">

            <strong>Property Information</strong>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="180">Property Code</th>
                            <td>{{ $property->code }}</td>
                        </tr>

                        <tr>
                            <th>Name</th>
                            <td>{{ $property->name }}</td>
                        </tr>
                        <tr><th>Managed by</th><td><strong>{{ $property->organization?->name }}</strong><small class="d-block text-muted">{{ $property->organization?->account_type === 'property_agent' ? 'Property agent / management company' : 'Property owner' }}@if($property->organization?->phone) · {{ $property->organization->phone }}@endif</small></td></tr>

                        <tr>
                            <th>Type</th>
                            <td>{{ $property->type }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>

                                @if($property->status=="Active")

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="180">County</th>
                            <td>{{ $property->county }}</td>
                        </tr>

                        <tr>
                            <th>Town</th>
                            <td>{{ $property->town }}</td>
                        </tr>

                        <tr>
                            <th>Address</th>
                            <td>{{ $property->address }}</td>
                        </tr>

                        <tr>
                            <th>Floors</th>
                            <td>{{ $property->floors }}</td>
                        </tr>

                    </table>

                </div>

            </div>

            @if($property->description)

                <hr>

                <strong>Description</strong>

                <p class="mb-0">
                    {{ $property->description }}
                </p>

            @endif

        </div>

    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Trust and verification</strong>
            @php($verificationClass = $property->verification_status === 'Verified' ? 'success' : ($property->verification_status === 'Rejected' ? 'danger' : 'warning'))
            <span class="badge bg-{{ $verificationClass }} {{ $verificationClass === 'warning' ? 'text-dark' : '' }}">{{ $property->verification_status }}</span>
        </div>
        <div class="card-body">
            @if($property->verification_notes)<p class="mb-3"><strong>Reviewer note:</strong> {{ $property->verification_notes }}</p>@endif
            <h6>Amenities</h6>
            @forelse($property->amenities ?? [] as $amenity)<span class="badge text-bg-light border me-1 mb-2"><i class="bi bi-check2-circle text-success"></i> {{ $amenity }}</span>@empty<p class="text-muted">No amenities have been added yet.</p>@endforelse
            <hr>
            <h6>Property media and evidence</h6>
            <div class="row g-3">
                @forelse($property->files as $file)
                    <div class="col-sm-6 col-lg-3">
                        @if($file->is_image)<a href="{{ $file->url }}" target="_blank"><img src="{{ $file->url }}" alt="{{ $file->original_name }}" class="img-fluid rounded border" style="height:150px;width:100%;object-fit:cover"></a>
                        @else<a href="{{ $file->url }}" target="_blank" class="d-flex align-items-center gap-2 border rounded p-3 text-decoration-none h-100"><i class="bi bi-file-earmark-pdf fs-3 text-danger"></i><span>{{ $file->original_name }}</span></a>@endif
                        <small class="d-block text-secondary mt-1">{{ str_replace('_', ' ', $file->category) }}</small>
                    </div>
                @empty
                    <p class="text-muted mb-0">No photos or documents have been uploaded.</p>
                @endforelse
            </div>
        </div>
    </div>


    <!-- Units -->

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between">

            <strong>Units</strong>

            <span class="badge bg-primary">

                {{ $property->units->count() }} Units

            </span>

        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Unit</th>

                        <th>Type</th>

                        <th>Monthly Rent</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($property->units as $unit)

                    <tr>

                        <td>

                            <strong>{{ $unit->unit_number }}</strong>

                        </td>

                        <td>{{ $unit->unit_type }}</td>

                        <td>

                            KSh {{ number_format($unit->monthly_rent,2) }}

                        </td>

                        <td>

                            @if($unit->status=="Occupied")

                                <span class="badge bg-success">

                                    Occupied

                                </span>

                            @elseif($unit->status=="Vacant")

                                <span class="badge bg-warning text-dark">

                                    Vacant

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    Maintenance

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4" class="text-center py-4">

                            No units have been added to this property.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
