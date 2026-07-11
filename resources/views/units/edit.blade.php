@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Edit Unit</h3>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route('units.update', $unit) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <!-- Property -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Property</label>

                        <select name="property_id" class="form-select" required>

                            <option value="">Select Property</option>

                            @foreach($properties as $property)

                                <option value="{{ $property->id }}"
                                    {{ old('property_id', $unit->property_id) == $property->id ? 'selected' : '' }}>
                                    {{ $property->name }}
                                </option>

                            @endforeach

                        </select>
                    </div>

                    <!-- Unit Number -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit Number</label>

                        <input type="text"
                               name="unit_number"
                               class="form-control"
                               value="{{ old('unit_number', $unit->unit_number) }}"
                               required>
                    </div>

                    <!-- Unit Type -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit Type</label>

                        <select name="unit_type" class="form-select">

                            <option value="Bedsitter" {{ old('unit_type', $unit->unit_type) == 'Bedsitter' ? 'selected' : '' }}>Bedsitter</option>

                            <option value="Studio" {{ old('unit_type', $unit->unit_type) == 'Studio' ? 'selected' : '' }}>Studio</option>

                            <option value="1 Bedroom" {{ old('unit_type', $unit->unit_type) == '1 Bedroom' ? 'selected' : '' }}>1 Bedroom</option>

                            <option value="2 Bedroom" {{ old('unit_type', $unit->unit_type) == '2 Bedroom' ? 'selected' : '' }}>2 Bedroom</option>

                            <option value="3 Bedroom" {{ old('unit_type', $unit->unit_type) == '3 Bedroom' ? 'selected' : '' }}>3 Bedroom</option>

                            <option value="4 Bedroom" {{ old('unit_type', $unit->unit_type) == '4 Bedroom' ? 'selected' : '' }}>4 Bedroom</option>

                            <option value="Shop" {{ old('unit_type', $unit->unit_type) == 'Shop' ? 'selected' : '' }}>Shop</option>

                            <option value="Office" {{ old('unit_type', $unit->unit_type) == 'Office' ? 'selected' : '' }}>Office</option>

                        </select>
                    </div>

                    <!-- Monthly Rent -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Monthly Rent</label>

                        <input type="number"
                               name="monthly_rent"
                               class="form-control"
                               value="{{ old('monthly_rent', $unit->monthly_rent) }}"
                               required>
                    </div>

                    <!-- Deposit -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Deposit</label>

                        <input type="number"
                               name="deposit"
                               class="form-control"
                               value="{{ old('deposit', $unit->deposit) }}"
                               required>
                    </div>

                    <!-- Floor -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Floor</label>

                        <input type="number"
                               name="floor"
                               class="form-control"
                               value="{{ old('floor', $unit->floor) }}"
                               required>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option value="Vacant" {{ old('status', $unit->status) == 'Vacant' ? 'selected' : '' }}>Vacant</option>

                            <option value="Occupied" {{ old('status', $unit->status) == 'Occupied' ? 'selected' : '' }}>Occupied</option>

                            <option value="Maintenance" {{ old('status', $unit->status) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>

                        </select>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  rows="4"
                                  class="form-control">{{ old('description', $unit->description) }}</textarea>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    Update Unit
                </button>

                <a href="{{ route('units.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

@endsection