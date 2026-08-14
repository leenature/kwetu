<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Models\User;
use App\Models\PropertyClient;
use App\Models\ServicePartner;
use App\Notifications\WorkspaceActivity;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of properties.
     */
    public function index(Request $request)
    {
        $query = Property::query();

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('town', 'like', "%{$search}%")
                  ->orWhere('county', 'like', "%{$search}%");

            });

        }

        $properties = $query->latest()->paginate(10)->withQueryString();

        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a property.
     */
    public function create()
    {
        $clients = PropertyClient::orderBy('name')->get();
        $availablePartners = ServicePartner::where('is_active', true)->where('available_to_all_properties', true)->orderBy('name')->get();
        return view('properties.create', compact('clients', 'availablePartners'));
    }

    /**
     * Store a newly created property.
     */
    public function store(StorePropertyRequest $request)
    {
        $data = $request->validated();
        $uploads = collect(['exterior_photos', 'interior_photos', 'location_photos', 'verification_documents'])
            ->mapWithKeys(fn ($key) => [$key => $request->file($key, [])])->all();
        unset($data['exterior_photos'], $data['interior_photos'], $data['location_photos'], $data['verification_documents']);
        $partnerIds = $data['service_partner_ids'] ?? [];
        unset($data['service_partner_ids']);
        $data['organization_id'] = auth()->user()->organization_id;

        $property = Property::create($data);
        $property->servicePartners()->sync(ServicePartner::where('is_active', true)->where('available_to_all_properties', true)->whereIn('id', $partnerIds)->pluck('id'));
        $this->createVerificationChecklist($property);
        $this->storeFiles($property, $uploads);

        User::where('organization_id', $property->organization_id)->get()
            ->each(fn (User $user) => $user->notify(new WorkspaceActivity(
                'New property added', "{$property->name} was added to the portfolio.",
                'bi-buildings-fill', route('properties.show', $property),
            )));
        return redirect()
            ->route('properties.index')
            ->with('success', 'Property added successfully.');
    }

    /**
     * Display a property.
     */
   public function show(Property $property)
{
    $property->load([
    'units:id,property_id,unit_number,unit_type,monthly_rent,status',
    'files:id,property_id,category,path,original_name,mime_type,size',
    'client',
    'verificationItems.reviewer',
    ]);
    $servicePartners = ServicePartner::availableForProperty($property)->orderBy('name')->get();

    $totalUnits = $property->units->count();

    $occupiedUnits = $property->units
        ->where('status', 'Occupied')
        ->count();

    $vacantUnits = $property->units
        ->where('status', 'Vacant')
        ->count();

    $maintenanceUnits = $property->units
        ->where('status', 'Maintenance')
        ->count();

    $expectedRent = $property->units
        ->sum('monthly_rent');

    return view('properties.show', compact(
        'property',
        'totalUnits',
        'occupiedUnits',
        'vacantUnits',
        'maintenanceUnits',
        'expectedRent',
        'servicePartners'
    ));
}

    /**
     * Show the edit form.
     */
    public function edit(Property $property)
    {
        $clients = PropertyClient::orderBy('name')->get();
        $availablePartners = ServicePartner::availableForProperty($property)->orderBy('name')->get();
        $selectedPartnerIds = $property->servicePartners()->pluck('service_partners.id')->all();
        return view('properties.edit', compact('property', 'clients', 'availablePartners', 'selectedPartnerIds'));
    }

    /**
     * Update the property.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'code'    => 'required|unique:properties,code,' . $property->id,
            'name'    => 'required',
            'type'    => 'required',
            'county'  => 'required',
            'town'    => 'required',
            'address' => 'required',
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'floors'  => 'required|integer|min:1',
            'status'  => 'required',
            'property_client_id' => ['nullable', 'integer', 'exists:property_clients,id'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', 'max:100'],
            'service_partner_ids' => ['nullable', 'array'],
            'service_partner_ids.*' => ['integer', 'exists:service_partners,id'],
            'exterior_photos' => ['nullable', 'array', 'max:10'],
            'exterior_photos.*' => ['image', 'max:10240'],
            'interior_photos' => ['nullable', 'array', 'max:15'],
            'interior_photos.*' => ['image', 'max:10240'],
            'location_photos' => ['nullable', 'array', 'max:5'],
            'location_photos.*' => ['image', 'max:10240'],
            'verification_documents' => ['nullable', 'array', 'max:5'],
            'verification_documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $uploads = collect(['exterior_photos', 'interior_photos', 'location_photos', 'verification_documents'])
            ->mapWithKeys(fn ($key) => [$key => $request->file($key, [])])->all();
        unset($validated['exterior_photos'], $validated['interior_photos'], $validated['location_photos'], $validated['verification_documents']);
        $partnerIds = $validated['service_partner_ids'] ?? [];
        unset($validated['service_partner_ids']);

        $property->update($validated);
        $allowedPartnerIds = ServicePartner::availableForProperty($property)->whereIn('id', $partnerIds)->pluck('id');
        $property->servicePartners()->sync($allowedPartnerIds);
        $this->storeFiles($property, $uploads);

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Delete the property.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()
            ->route('properties.index')
            ->with('success', 'Property deleted successfully.');
    }

    private function storeFiles(Property $property, array $uploads): void
    {
        foreach ($uploads as $category => $files) {
            foreach ($files as $file) {
                $path = $file->store("properties/{$property->id}/{$category}", 'public');
                $property->files()->create([
                    'uploaded_by' => auth()->id(), 'category' => $category, 'path' => $path,
                    'original_name' => $file->getClientOriginalName(), 'mime_type' => $file->getMimeType(), 'size' => $file->getSize(),
                ]);
            }
        }
    }

    private function createVerificationChecklist(Property $property): void
    {
        foreach (['map_location' => 'Map location and coordinates', 'documents' => 'Ownership or management documents', 'photos' => 'Property and landmark photos', 'contact' => 'Owner or agent contact details'] as $key => $label) {
            $property->verificationItems()->firstOrCreate(['check_key' => $key], ['label' => $label]);
        }
    }
}
