@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3>👥 Tenants</h3>
            <small class="text-muted">Manage all tenants</small>
        </div>

        <a href="{{ route('tenants.create') }}" class="btn btn-primary">
            + Add Tenant
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
                        <th>Name</th>
                        <th>ID Number</th>
                        <th>Phone</th>
                        <th>Unit</th>
                        <th>Property</th>
                        <th width="170">Action</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($tenants as $tenant)

                    <tr>

                        <td>{{ $tenant->full_name }}</td>

                        <td>{{ $tenant->id_number }}</td>

                        <td>{{ $tenant->phone }}</td>

                        <td>{{ $tenant->unit->unit_number }}</td>

                        <td>{{ $tenant->unit->property->name }}</td>

                        <td>

                            <a href="{{ route('tenants.edit',$tenant) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('tenants.destroy',$tenant) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this tenant?')">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">
                            No tenants found.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $tenants->links() }}

        </div>

    </div>

</div>

@endsection