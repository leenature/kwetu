@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3>Add Tenant</h3>
            <small class="text-muted">Register a new tenant</small>
        </div>

        <a href="{{ route('tenants.index') }}" class="btn btn-secondary">
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

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route('tenants.store') }}" method="POST">

                @csrf

                <div class="row">

                    <!-- Full Name -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Full Name</label>

                        <input type="text"
                               name="full_name"
                               class="form-control"
                               value="{{ old('full_name') }}"
                               required>

                    </div>

                    <!-- ID Number -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">ID Number</label>

                        <input type="text"
                               name="id_number"
                               class="form-control"
                               value="{{ old('id_number') }}"
                               required>

                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Phone Number</label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone') }}"
                               required>

                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Email</label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email') }}">

                    </div>

                    <!-- Gender -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Gender</label>

                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>

                        </select>

                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Date of Birth</label>

                        <input type="date"
                               name="date_of_birth"
                               class="form-control">

                    </div>

                    <!-- Property -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Property</label>

                        <select id="property" class="form-select">

                            <option value="">Select Property</option>

                            @foreach($properties as $property)

                                <option value="{{ $property->id }}">
                                    {{ $property->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Unit -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Unit</label>

                        <select name="unit_id"
                                id="unit"
                                class="form-select"
                                required>

                            <option value="">
                                Select Property First
                            </option>

                        </select>

                    </div>

                    <!-- Occupation -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Occupation</label>

                        <input type="text"
                               name="occupation"
                               class="form-control"
                               value="{{ old('occupation') }}">

                    </div>

                    <!-- Employer -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Employer</label>

                        <input type="text"
                               name="employer"
                               class="form-control"
                               value="{{ old('employer') }}">

                    </div>

                    <!-- Emergency Contact -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Emergency Contact</label>

                        <input type="text"
                               name="emergency_contact_name"
                               class="form-control"
                               value="{{ old('emergency_contact_name') }}">

                    </div>

                    <!-- Emergency Phone -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Emergency Contact Phone</label>

                        <input type="text"
                               name="emergency_contact_phone"
                               class="form-control"
                               value="{{ old('emergency_contact_phone') }}">

                    </div>

                    <!-- Relationship -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">Relationship</label>

                        <input type="text"
                               name="relationship"
                               class="form-control"
                               value="{{ old('relationship') }}">

                    </div>

                    <!-- Notes -->
                    <div class="col-md-12 mb-3">

                        <label class="form-label">Notes</label>

                        <textarea name="notes"
                                  class="form-control"
                                  rows="4">{{ old('notes') }}</textarea>

                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    Save Tenant
                </button>

                <a href="{{ route('tenants.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

<script>
document.getElementById('property').addEventListener('change', async function () {
    const propertyId = this.value;
    const unit = document.getElementById('unit');

    if (!propertyId) {
        unit.innerHTML = '<option value="">Select Property First</option>';
        return;
    }

    unit.innerHTML = '<option value="">Loading units...</option>';

    try {
        const response = await fetch(`/properties/${propertyId}/available-units`, {
            headers: { Accept: 'application/json' }
        });

        if (!response.ok) {
            throw new Error('Could not load units.');
        }

        const units = await response.json();

        unit.innerHTML = '<option value="">Select Unit</option>';

        if (!units.length) {
            unit.innerHTML = '<option value="">No vacant units available</option>';
            return;
        }

        units.forEach((item) => {
            unit.innerHTML += `
                <option value="${item.id}">
                    ${item.unit_number} — ${item.unit_type} — KSh ${item.monthly_rent}
                </option>
            `;
        });
    } catch (error) {
        unit.innerHTML = '<option value="">Unable to load units</option>';
    }
});
</script>
@endsection