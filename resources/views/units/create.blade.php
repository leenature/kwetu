@extends('layouts.app')

@section('title', 'Add Unit')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Add Unit</h3>
            <small class="text-muted">
                Create a new unit for a property
            </small>
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form action="{{ route('units.store') }}" method="POST">

                @csrf

                <div class="row">

                    {{-- PROPERTY --}}
                    @if($selectedProperty)

                        <input
                            type="hidden"
                            name="property_id"
                            value="{{ $selectedProperty->id }}">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Property
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $selectedProperty->name }}"
                                readonly>

                        </div>

                    @else

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Property
                            </label>

                            <select
                                name="property_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Property
                                </option>

                                @foreach($properties as $property)

                                    <option
                                        value="{{ $property->id }}"
                                        {{ old('property_id') == $property->id ? 'selected' : '' }}>

                                        {{ $property->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    @endif



                    {{-- UNIT NUMBER --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Unit Number
                        </label>

                        <input
                            type="text"
                            name="unit_number"
                            class="form-control"
                            value="{{ old('unit_number') }}"
                            required>

                    </div>



                    {{-- UNIT TYPE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Unit Type
                        </label>

                        <select
                            name="unit_type"
                            class="form-select">

                            <option>Bedsitter</option>
                            <option>Studio</option>
                            <option>1 Bedroom</option>
                            <option>2 Bedroom</option>
                            <option>3 Bedroom</option>
                            <option>4 Bedroom</option>
                            <option>Shop</option>
                            <option>Office</option>

                        </select>

                    </div>



                    {{-- MONTHLY RENT --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Monthly Rent
                        </label>

                        <input
                            type="number"
                            name="monthly_rent"
                            class="form-control"
                            value="{{ old('monthly_rent') }}"
                            required>

                    </div>



                    {{-- DEPOSIT --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Deposit
                        </label>

                        <input
                            type="number"
                            name="deposit"
                            class="form-control"
                            value="{{ old('deposit') }}"
                            required>

                    </div>



                    {{-- FLOOR --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Floor
                        </label>

                        <input
                            type="number"
                            name="floor"
                            class="form-control"
                            value="{{ old('floor',1) }}">

                    </div>



                    {{-- STATUS --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="Vacant">Vacant</option>
                            <option value="Occupied">Occupied</option>
                            <option value="Maintenance">Maintenance</option>

                        </select>

                    </div>



                    {{-- DESCRIPTION --}}
                    <div class="col-md-12 mb-4">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="form-control">{{ old('description') }}</textarea>

                    </div>

                </div>



                <button class="btn btn-primary">

                    <i class="bi bi-check-circle"></i>

                    Save Unit

                </button>

                <a href="{{ url()->previous() }}"
                   class="btn btn-light border">

                    Cancel

                </a>

            </form>

        </div>

    </div>

</div>

@endsection