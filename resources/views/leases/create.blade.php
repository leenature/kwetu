@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3>Create Lease</h3>
            <small class="text-muted">Create a new lease agreement</small>
        </div>

        <a href="{{ route('leases.index') }}" class="btn btn-secondary">
            Back
        </a>

    </div>

    @if($errors->any())

        <div class="alert alert-danger">

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route('leases.store') }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Tenant</label>

                        <select name="tenant_id"
                                id="tenant"
                                class="form-select"
                                required>

                            <option value="">Select Tenant</option>

                            @foreach($tenants as $tenant)

                                <option value="{{ $tenant->id }}">
                                    {{ $tenant->full_name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Property</label>

                        <input type="text"
                               id="property"
                               class="form-control"
                               readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Unit</label>

                        <input type="text"
                               id="unit"
                               class="form-control"
                               readonly>

                        <input type="hidden"
                               name="unit_id"
                               id="unit_id">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Monthly Rent</label>

                        <input type="text"
                               id="rent"
                               name="rent_amount"
                               class="form-control"
                               readonly>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Lease Start Date</label>

                        <input type="date"
                               name="start_date"
                               class="form-control"
                               required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Lease End Date</label>

                        <input type="date"
                               name="end_date"
                               class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Deposit</label>

                        <input type="number"
                               name="deposit_amount"
                               class="form-control"
                               value="0">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Payment Frequency</label>

                        <select name="payment_frequency"
                                class="form-select">

                            <option>Monthly</option>
                            <option>Quarterly</option>
                            <option>Yearly</option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-3">

                        <label>Notes</label>

                        <textarea name="notes"
                                  class="form-control"
                                  rows="4"></textarea>

                    </div>

                </div>

                <button class="btn btn-primary">
                    Save Lease
                </button>

            </form>

        </div>

    </div>

</div>
<script>

document.getElementById('tenant').addEventListener('change', function(){

    let id = this.value;

    fetch('/tenant/' + id)

    .then(res => res.json())

    .then(data => {

        document.getElementById('property').value =
            data.unit.property.name;

        document.getElementById('unit').value =
            data.unit.unit_number;

        document.getElementById('unit_id').value =
            data.unit.id;

        document.getElementById('rent').value =
            data.unit.monthly_rent;

    });

});

</script>

@endsection