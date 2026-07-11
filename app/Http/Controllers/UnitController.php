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

    public function create()
    {
        $properties = Property::orderBy('name')->get();

        return view('units.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id'   => 'required|exists:properties,id',
            'unit_number'   => 'required',
            'unit_type'     => 'required',
            'monthly_rent'  => 'required|numeric',
            'deposit'       => 'required|numeric',
            'floor'         => 'required|integer',
            'status'        => 'required',
        ]);

        Unit::create($request->all());

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
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'unit_number' => 'required',
        'unit_type' => 'required',
        'monthly_rent' => 'required|numeric',
        'deposit' => 'required|numeric',
        'floor' => 'required|integer',
        'status' => 'required',
    ]);

    $unit->update($request->all());

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