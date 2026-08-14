@extends('layouts.app')

@section('title','Property Units')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                {{ $property->name }}
            </h2>

            <small class="text-muted">
                Units Management
            </small>

        </div>

        <div>

            <a href="{{ route('units.create', ['property'=>$property->id]) }}"
               class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Add Unit

            </a>

        </div>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead>

                <tr>

                    <th>Unit</th>

                    <th>Type</th>

                    <th>Rent</th>

                    <th>Status</th>

                    <th width="170">Actions</th>

                </tr>

                </thead>

                <tbody>

                @forelse($units as $unit)

                    <tr>

                        <td>

                            <strong>

                                {{ $unit->unit_number }}

                            </strong>

                        </td>

                        <td>

                            {{ $unit->unit_type }}

                        </td>

                        <td>

                            KSh {{ number_format($unit->monthly_rent) }}

                        </td>

                        <td>

                            @if($unit->status=='Occupied')

                                <span class="badge bg-success">

                                    Occupied

                                </span>

                            @elseif($unit->status=='Vacant')

                                <span class="badge bg-warning text-dark">

                                    Vacant

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    Maintenance

                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('units.show',$unit) }}"
                               class="btn btn-sm btn-outline-primary">

                                View

                            </a>

                            <a href="{{ route('units.edit',$unit) }}"
                               class="btn btn-sm btn-outline-warning">

                                Edit

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center">

                            No Units Found

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