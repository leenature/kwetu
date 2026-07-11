<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::latest()->paginate(10);

        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(StorePropertyRequest $request)
    {
        Property::create($request->validated());

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property added successfully.');
    }

    public function show(Property $property)
    {
        //
    }

  public function edit(Property $property)
{
    return view('properties.edit', compact('property'));
}    public function update(Request $request, Property $property)
{
    $request->validate([
        'code' => 'required|unique:properties,code,' . $property->id,
        'name' => 'required',
        'county' => 'required',
        'town' => 'required',
    ]);

    $property->update($request->all());

    return redirect()
        ->route('properties.index')
        ->with('success', 'Property updated successfully.');
}

   public function destroy(Property $property)
{
    $property->delete();

    return redirect()
        ->route('properties.index')
        ->with('success', 'Property deleted successfully.');
}
}