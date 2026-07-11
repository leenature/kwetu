@extends('layouts.app')

@section('content')

<div class="container-fluid">

<h3 class="mb-4">
🏠 Kwetu Dashboard
</h3>


<div class="row">


<div class="col-md-3 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6>Properties</h6>

<h2>{{ $properties }}</h2>

</div>

</div>

</div>



<div class="col-md-3 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6>Total Units</h6>

<h2>{{ $units }}</h2>

</div>

</div>

</div>



<div class="col-md-3 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6>Occupied Units</h6>

<h2>{{ $occupiedUnits }}</h2>

</div>

</div>

</div>



<div class="col-md-3 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6>Vacant Units</h6>

<h2>{{ $vacantUnits }}</h2>

</div>

</div>

</div>


</div>



<div class="row">


<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6>Tenants</h6>

<h2>{{ $tenants }}</h2>

</div>

</div>

</div>



<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6>Active Leases</h6>

<h2>{{ $activeLeases }}</h2>

</div>

</div>

</div>



<div class="col-md-4 mb-3">

<div class="card shadow-sm">

<div class="card-body">

<h6>Expected Rent</h6>

<h2>
KES {{ number_format($expectedRent) }}
</h2>

</div>

</div>

</div>


</div>



<div class="card shadow-sm mt-3">

<div class="card-body">


<h5>
Recent Payments
</h5>


<table class="table">


<tr>

<th>Tenant</th>

<th>Amount</th>

<th>Date</th>

</tr>


@foreach($recentPayments as $payment)

<tr>

<td>
{{ $payment->lease->tenant->full_name }}
</td>

<td>
KES {{ number_format($payment->amount_paid) }}
</td>

<td>
{{ $payment->payment_date }}
</td>

</tr>

@endforeach


</table>


</div>

</div>


</div>

@endsection