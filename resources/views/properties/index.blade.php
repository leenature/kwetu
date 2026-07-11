@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3>Properties</h3>
            <small class="text-muted">
                Manage all your properties
            </small>
        </div>

        <a href="{{ route('properties.create') }}" class="btn btn-primary">
            + Add Property
        </a>

    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-hover">

                <thead>

                <tr>

                    <th>Code</th>

                    <th>Name</th>

                    <th>Town</th>

                    <th>Status</th>

                    <th width="150">Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($properties as $property)

                    <tr>

                        <td>{{ $property->code }}</td>

                        <td>{{ $property->name }}</td>

                        <td>{{ $property->town }}</td>

                        <td>{{ $property->status }}</td>

                        <td>

                          <td>
    <a href="{{ route('properties.edit', $property) }}"
       class="btn btn-sm btn-warning">
        Edit
    </a>

    <form action="{{ route('properties.destroy', $property) }}"
          method="POST"
          class="d-inline">

        @csrf
        @method('DELETE')

        <button class="btn btn-sm btn-danger"
                onclick="return confirm('Delete this property?')">
            Delete
        </button>

    </form>
</td>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center">

                            No properties found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection