@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container-fluid">

<div class="d-flex justify-content-between mb-4">

<div>

<h3>📄 Lease Agreements</h3>

<small class="text-muted">
Manage all lease agreements
</small>

</div>

<a href="{{ route('leases.create') }}"
class="btn btn-primary">

+ New Lease

</a>

</div>

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<div class="card">

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>

<th>Tenant</th>

<th>Property</th>

<th>Unit</th>

<th>Rent</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

@forelse($leases as $lease)

<tr>

<td>{{ $lease->tenant->full_name }}</td>

<td>{{ $lease->unit->property->name }}</td>

<td>{{ $lease->unit->unit_number }}</td>

<td>KES {{ number_format($lease->rent_amount) }}</td>

<td>{{ $lease->status }}</td>

<td>

Edit

Delete

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center">

No lease agreements found.

</td>

</tr>

@endforelse

</tbody>

</table>

{{ $leases->links() }}

</div>

</div>

</div>

@endsection