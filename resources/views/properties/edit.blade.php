@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Edit Property</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('properties.update', $property) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('properties._form')

                <button class="btn btn-primary">Update Property</button>

                <a href="{{ route('properties.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </form>
        </div>
    </div>
</div>

@endsection
