@extends('layouts.app')

@section('content')

<h2 class="mb-4">
    Welcome back, {{ Auth::user()->name }}
</h2>

<div class="row">

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body">

                <h5>Properties</h5>

                <h2>0</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body">

                <h5>Units</h5>

                <h2>0</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body">

                <h5>Tenants</h5>

                <h2>0</h2>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card shadow-sm">

            <div class="card-body">

                <h5>Payments</h5>

                <h2>KES 0</h2>

            </div>

        </div>

    </div>

</div>

@endsection