<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class ResidenceController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::query()
            ->with(['client', 'units' => fn ($query) => $query->where('status', 'Vacant')->orderBy('monthly_rent')])
            ->where('status', 'Active')
            ->where('verification_status', 'Verified')
            ->whereHas('units', fn ($query) => $query->where('status', 'Vacant'))
            ->when($request->filled('area'), fn ($query) => $query->where(fn ($sub) => $sub->where('town', 'like', '%' . $request->area . '%')->orWhere('county', 'like', '%' . $request->area . '%')))
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->type))
            ->orderBy('town')->paginate(9)->withQueryString();

        $types = Property::where('status', 'Active')->where('verification_status', 'Verified')->distinct()->orderBy('type')->pluck('type');
        return view('residences.index', compact('properties', 'types'));
    }

    public function show(Property $property)
    {
        abort_unless($property->status === 'Active' && $property->verification_status === 'Verified', 404);
        $property->load(['client', 'units' => fn ($query) => $query->where('status', 'Vacant')->orderBy('monthly_rent')]);
        abort_if($property->units->isEmpty(), 404);
        $recommendations = Property::with(['units' => fn ($query) => $query->where('status', 'Vacant')->orderBy('monthly_rent')])
            ->whereKeyNot($property->id)->where('status', 'Active')->where('verification_status', 'Verified')
            ->where('type', $property->type)->whereHas('units', fn ($query) => $query->where('status', 'Vacant'))->limit(3)->get();
        return view('residences.show', compact('property', 'recommendations'));
    }
}
