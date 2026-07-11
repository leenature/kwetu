@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-4">Edit Property</h3>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route('properties.update', $property) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Property Code</label>
                        <input type="text" name="code" class="form-control"
                               value="{{ old('code', $property->code) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Property Name</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $property->name) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Town</label>
                        <input type="text" name="town" class="form-control"
                               value="{{ old('town', $property->town) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>County</label>
                        <input type="text" name="county" class="form-control"
                               value="{{ old('county', $property->county) }}">
                    </div>

                    <form action="{{ route('properties.update', $property) }}" method="POST">

    @csrf
    @method('PUT')

    @include('properties._form')

    <button class="btn btn-primary">
        Update Property
    </button>

</form>
                        <a href="{{ route('properties.index') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection