@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3>Units</h3>
            <small class="text-muted">Manage property units</small>
        </div>

        <a href="{{ route('units.create') }}" class="btn btn-primary">
            + Add Unit
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
                        <th>Property</th>
                        <th>Unit No.</th>
                        <th>Type</th>
                        <th>Rent</th>
                        <th>Status</th>
                        <th width="170">Action</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($units as $unit)

                    <tr>

                        <td>{{ $unit->property->name }}</td>

                        <td>{{ $unit->unit_number }}</td>

                        <td>{{ $unit->unit_type }}</td>

                        <td>KES {{ number_format($unit->monthly_rent,2) }}</td>

                        <td>
                            @if($unit->status == 'Vacant')
                                <span class="badge bg-success">Vacant</span>
                            @elseif($unit->status == 'Occupied')
                                <span class="badge bg-danger">Occupied</span>
                            @else
                                <span class="badge bg-warning text-dark">Maintenance</span>
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('units.edit',$unit) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('units.destroy',$unit) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this unit?')">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">
                            No units found.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $units->links() }}

        </div>

    </div>

</div>

@endsection