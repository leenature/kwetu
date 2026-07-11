@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Add Unit</h3>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route('units.store') }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Property</label>

                        <select name="property_id" class="form-select" required>

                            <option value="">Select Property</option>

                            @foreach($properties as $property)

                                <option value="{{ $property->id }}">
                                    {{ $property->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit Number</label>
                        <input type="text"
                               name="unit_number"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit Type</label>

                        <select name="unit_type" class="form-select">

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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Monthly Rent</label>

                        <input type="number"
                               name="monthly_rent"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Deposit</label>

                        <input type="number"
                               name="deposit"
                               class="form-control"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Floor</label>

                        <input type="number"
                               name="floor"
                               class="form-control"
                               value="1">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option>Vacant</option>
                            <option>Occupied</option>
                            <option>Maintenance</option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label class="form-label">Description</label>

                        <textarea name="description"
                                  rows="4"
                                  class="form-control"></textarea>

                    </div>

                </div>

                <button class="btn btn-primary">
                    Save Unit
                </button>

                <a href="{{ route('units.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

@endsection