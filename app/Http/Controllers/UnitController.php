<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Property;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('property')->latest()->paginate(10);

        return view('units.index', compact('units'));
    }
public function create(Request $request)
{
    $properties = Property::orderBy('name')->get();

    $selectedProperty = $request->filled('property')
        ? Property::findOrFail($request->integer('property'))
        : null;

    return view('units.create', compact('properties', 'selectedProperty'));
}
public function availableUnits(Property $property)
{
    return response()->json(
        $property->units()
            ->where('status', 'Vacant')
            ->orderBy('unit_number')
            ->get(['id', 'unit_number', 'unit_type', 'monthly_rent'])
    );
}
public function propertyUnits(Property $property)
{
    $units = $property->units()
        ->latest()
        ->paginate(15);

    return view('units.property-units', compact(
        'property',
        'units'
    ));
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id'   => 'required|exists:properties,id',
            'unit_number'   => 'required',
            'unit_type'     => 'required',
            'monthly_rent'  => 'required|numeric',
            'deposit'       => 'required|numeric',
            'floor'         => 'required|integer',
            'status'        => 'required',
        ]);

        // Property uses an organization scope, so this also prevents a crafted
        // request from attaching a unit to another owner's property.
        Property::findOrFail($validated['property_id']);

        Unit::create($validated);

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit added successfully.');
    }

    public function edit(Unit $unit)
{
    $properties = Property::orderBy('name')->get();

    return view('units.edit', compact('unit', 'properties'));
}
public function update(Request $request, Unit $unit)
{
    $validated = $request->validate([
        'property_id' => 'required|exists:properties,id',
        'unit_number' => 'required',
        'unit_type' => 'required',
        'monthly_rent' => 'required|numeric',
        'deposit' => 'required|numeric',
        'floor' => 'required|integer',
        'status' => 'required',
    ]);

    Property::findOrFail($validated['property_id']);

    $unit->update($validated);

    return redirect()
        ->route('units.index')
        ->with('success', 'Unit updated successfully.');
}

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()
            ->route('units.index')
            ->with('success', 'Unit deleted successfully.');
    }
}
