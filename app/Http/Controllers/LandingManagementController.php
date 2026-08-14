<?php
namespace App\Http\Controllers;
use App\Models\LandingSetting;
use App\Models\ServicePartner;
use App\Models\Property;
use Illuminate\Http\Request;

class LandingManagementController extends Controller {
    private function authorizeAdmin(): void { abort_unless(auth()->user()?->role === 'Super Admin', 403); }
    public function index() { $this->authorizeAdmin(); $content = LandingSetting::pluck('value', 'key'); $partners = ServicePartner::with('properties:id')->orderBy('sort_order')->get(); $properties = Property::orderBy('name')->get(['id', 'name', 'town', 'county']); return view('settings.landing', compact('content', 'partners', 'properties')); }
    public function updateContent(Request $request) { $this->authorizeAdmin(); $data = $request->validate(['hero_title' => ['required','string','max:120'], 'hero_text' => ['required','string','max:400']]); foreach ($data as $key => $value) LandingSetting::updateOrCreate(['key' => $key], ['value' => $value]); return back()->with('success', 'Landing page text updated.'); }
    public function storePartner(Request $request) { $this->authorizeAdmin(); $data = $request->validate(['name' => ['required','string','max:100'], 'website' => ['nullable','url','max:255'], 'description' => ['nullable','string','max:150'], 'icon' => ['nullable','string','max:50'], 'available_to_all_properties' => ['nullable','boolean']]); $data['icon'] = $data['icon'] ?: 'bi-link-45deg'; $data['available_to_all_properties'] = $request->boolean('available_to_all_properties'); $data['sort_order'] = (ServicePartner::max('sort_order') ?? 0) + 1; ServicePartner::create($data); return back()->with('success', 'Service partner added.'); }
    public function updatePartner(Request $request, ServicePartner $partner) { $this->authorizeAdmin(); $data = $request->validate(['name' => ['required','string','max:100'], 'website' => ['nullable','url','max:255'], 'description' => ['nullable','string','max:150'], 'icon' => ['nullable','string','max:50'], 'is_active' => ['nullable','boolean'], 'available_to_all_properties' => ['nullable','boolean'], 'property_ids' => ['nullable','array'], 'property_ids.*' => ['integer','exists:properties,id']]); $data['is_active'] = $request->boolean('is_active'); $data['available_to_all_properties'] = $request->boolean('available_to_all_properties'); $propertyIds = $data['property_ids'] ?? []; unset($data['property_ids']); $partner->update($data); $partner->properties()->sync($propertyIds); return back()->with('success', 'Service partner availability updated.'); }
    public function destroyPartner(ServicePartner $partner) { $this->authorizeAdmin(); $partner->delete(); return back()->with('success', 'Partner removed.'); }
}
