@extends('layouts.app')

@section('title', 'Add Property')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Add Property</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('properties._form')
                <button class="btn btn-primary">Save Property</button>
                <a href="{{ route('properties.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
