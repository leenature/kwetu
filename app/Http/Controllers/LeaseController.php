<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Tenant;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index()
    {
        $leases = Lease::with(['tenant','unit.property'])
                    ->latest()
                    ->paginate(10);

        return view('leases.index', compact('leases'));
    }

    public function create()
{
    $tenants = Tenant::with('unit.property')
                    ->orderBy('full_name')
                    ->get();

    return view('leases.create', compact('tenants'));
}
    public function store(Request $request)
{
    $validated = $request->validate([
        'tenant_id' => 'required|exists:tenants,id',
        'unit_id' => 'required|exists:units,id',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'rent_amount' => 'required|numeric',
        'deposit_amount' => 'nullable|numeric',
        'payment_frequency' => 'required',
        'notes' => 'nullable',
    ]);

    $validated['status'] = 'Active';

    Lease::create($validated);

    return redirect()
        ->route('leases.index')
        ->with('success', 'Lease created successfully.');
}

    public function edit(Lease $lease)
    {
        //
    }

    public function update(Request $request, Lease $lease)
    {
        //
    }

    public function destroy(Lease $lease)
    {
        //
    }
}