@extends('layouts.app')

@section('content')
@include('properties._form')


<div class="container-fluid">

    <h3 class="mb-4">Add Property</h3>

    <div class="card shadow-sm">

        <div class="card-body">

            <form action="{{ route('properties.store') }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Property Code</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                        @error('code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Property Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Property Type</label>
                        <select name="type" class="form-select">
                            <option value="">Select Type</option>
                            <option>Apartment</option>
                            <option>Commercial</option>
                            <option>Hostel</option>
                            <option>Maisonette</option>
                            <option>Office</option>
                            <option>Single House</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>County</label>
                        <input type="text" name="county" class="form-control" value="{{ old('county') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Town</label>
                        <input type="text" name="town" class="form-control" value="{{ old('town') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Floors</label>
                        <input type="number" name="floors" class="form-control" value="1">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>

                </div>

                <button class="btn btn-primary">
                    Save Property
                </button>

                <a href="{{ route('properties.index') }}" class="btn btn-secondary">
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

@endsection