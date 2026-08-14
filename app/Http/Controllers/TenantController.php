<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use App\Models\Lease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TenantController extends Controller
{
   public function index()
{
    $tenants = Tenant::with('currentLease.unit.property')
        ->latest()
        ->paginate(10);

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
        'phone' => 'required|string|max:30',
        'email' => 'nullable|email',
        'gender' => 'required|in:Male,Female,Other',
        'date_of_birth' => 'nullable|date',
        'occupation' => 'nullable|string|max:255',
        'employer' => 'nullable|string|max:255',
        'emergency_contact_name' => 'nullable|string|max:255',
        'emergency_contact_phone' => 'nullable|string|max:30',
        'relationship' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ]);

    $organizationId = auth()->user()->organization_id;

    if (!$organizationId) {
        return back()
            ->withInput()
            ->withErrors([
                'organization' => 'Your user account is not assigned to an organization.',
            ]);
    }

    DB::transaction(function () use ($validated, $organizationId) {
        $unit = Unit::whereKey($validated['unit_id'])
            ->where('status', 'Vacant')
            ->lockForUpdate()
            ->firstOrFail();

        $tenant = Tenant::create([
            'organization_id' => $organizationId,
            'full_name' => $validated['full_name'],
            'id_number' => $validated['id_number'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'portal_token' => Str::random(48),
            'gender' => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'occupation' => $validated['occupation'],
            'employer' => $validated['employer'],
            'emergency_contact_name' => $validated['emergency_contact_name'],
            'emergency_contact_phone' => $validated['emergency_contact_phone'],
            'relationship' => $validated['relationship'],
            'notes' => $validated['notes'],
        ]);

        Lease::create([
            'organization_id' => $organizationId,
            'tenant_id' => $tenant->id,
            'unit_id' => $unit->id,
            'start_date' => now()->toDateString(),
            'rent_amount' => $unit->monthly_rent,
            'deposit_amount' => $unit->deposit,
            'payment_frequency' => 'Monthly',
            'status' => 'Active',
        ]);

        $unit->update(['status' => 'Occupied']);
    });

    return redirect()
        ->route('tenants.index')
        ->with('success', 'Tenant and active lease created successfully.');
}


    public function edit(Tenant $tenant)
{
    $tenant->load('currentLease.unit.property');

    return view('tenants.edit', compact('tenant'));
}

public function update(Request $request, Tenant $tenant)
{
    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'id_number' => [
            'required',
            'string',
            'max:255',
            Rule::unique('tenants', 'id_number')->ignore($tenant),
        ],
        'phone' => 'required|string|max:30',
        'email' => 'nullable|email',
        'gender' => 'required|in:Male,Female,Other',
        'date_of_birth' => 'nullable|date',
        'occupation' => 'nullable|string|max:255',
        'employer' => 'nullable|string|max:255',
        'emergency_contact_name' => 'nullable|string|max:255',
        'emergency_contact_phone' => 'nullable|string|max:30',
        'relationship' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
    ]);

    $tenant->update($validated);

    return redirect()
        ->route('tenants.index')
        ->with('success', 'Tenant details updated successfully.');
}
    public function destroy(Tenant $tenant)
{
    DB::transaction(function () use ($tenant) {
        $activeUnitIds = Lease::where('tenant_id', $tenant->id)
            ->where('status', 'Active')
            ->lockForUpdate()
            ->pluck('unit_id');

        Unit::whereIn('id', $activeUnitIds)
            ->update(['status' => 'Vacant']);

        $tenant->delete();
    });

    return redirect()
        ->route('tenants.index')
        ->with('success', 'Tenant deleted and assigned unit released successfully.');
}
}
