<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;


class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('unit.property')->latest()->paginate(10);

        return view('tenants.index', compact('tenants'));
    }

    public function create()
{
    $properties = \App\Models\Property::orderBy('name')->get();

    return view('tenants.create', compact('properties'));
}
    public function store(Request $request)
{
    $validated = $request->validate([
        'unit_id' => 'required|exists:units,id',
        'full_name' => 'required|string|max:255',
        'id_number' => 'required|unique:tenants,id_number',
        'phone' => 'required',
        'email' => 'nullable|email',
        'gender' => 'nullable',
        'date_of_birth' => 'nullable|date',
        'occupation' => 'nullable',
        'employer' => 'nullable',
        'emergency_contact_name' => 'nullable',
        'emergency_contact_phone' => 'nullable',
        'relationship' => 'nullable',
        'notes' => 'nullable',
    ]);

    Tenant::create($validated);

    Unit::where('id', $validated['unit_id'])->update([
        'status' => 'Occupied'
    ]);

    return redirect()
        ->route('tenants.index')
        ->with('success', 'Tenant added successfully.');
}
    public function edit(Tenant $tenant)
    {
        //
    }

    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    public function destroy(Tenant $tenant)
    {
        //
    }
}