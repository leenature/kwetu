@extends('layouts.app')

@section('title', 'Edit Tenant')

@section('content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-person-gear me-2"></i>
                Edit Tenant
            </h3>
            <small class="text-muted">Update {{ $tenant->full_name }}’s profile details.</small>
        </div>

        <a href="{{ route('tenants.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($tenant->currentLease)
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <span>
                <i class="bi bi-house-check-fill me-2"></i>
                Current unit:
                <strong>{{ $tenant->currentLease->unit->unit_number }}</strong>
                at {{ $tenant->currentLease->unit->property->name }}.
            </span>

            <a href="{{ route('leases.edit', $tenant->currentLease) }}"
               class="btn btn-sm btn-outline-primary">
                Manage Lease
            </a>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('tenants.update', $tenant) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control"
                               value="{{ old('full_name', $tenant->full_name) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">ID Number</label>
                        <input type="text" name="id_number" class="form-control"
                               value="{{ old('id_number', $tenant->id_number) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                               value="{{ old('phone', $tenant->phone) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $tenant->email) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            @foreach(['Male', 'Female', 'Other'] as $gender)
                                <option value="{{ $gender }}"
                                    @selected(old('gender', $tenant->gender) === $gender)>
                                    {{ $gender }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control"
                               value="{{ old('date_of_birth', optional($tenant->date_of_birth)->format('Y-m-d')) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Occupation</label>
                        <input type="text" name="occupation" class="form-control"
                               value="{{ old('occupation', $tenant->occupation) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Employer</label>
                        <input type="text" name="employer" class="form-control"
                               value="{{ old('employer', $tenant->employer) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Emergency Contact Name</label>
                        <input type="text" name="emergency_contact_name" class="form-control"
                               value="{{ old('emergency_contact_name', $tenant->emergency_contact_name) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Emergency Contact Phone</label>
                        <input type="text" name="emergency_contact_phone" class="form-control"
                               value="{{ old('emergency_contact_phone', $tenant->emergency_contact_phone) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Relationship</label>
                        <input type="text" name="relationship" class="form-control"
                               value="{{ old('relationship', $tenant->relationship) }}">
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" rows="4" class="form-control">{{ old('notes', $tenant->notes) }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i>
                    Save Changes
                </button>

                <a href="{{ route('tenants.index') }}" class="btn btn-light border">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>

@endsection