<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\ServicePartner;
use App\Models\Unit;
use App\Models\User;
use App\Notifications\WorkspaceActivity;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $properties = Property::orderBy('name')->get(['id', 'name']);
        $requests = MaintenanceRequest::with(['property:id,name', 'property.servicePartners:id,name', 'unit:id,unit_number', 'tenant:id,full_name', 'servicePartner:id,name'])
            ->when($request->filled('property_id'), fn ($query) => $query->where('property_id', $request->integer('property_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()->paginate(15)->withQueryString();
        return view('maintenance.index', compact('requests', 'properties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['property_id' => ['required','exists:properties,id'], 'unit_id' => ['nullable','exists:units,id'], 'title' => ['required','string','max:150'], 'description' => ['nullable','string','max:2000'], 'category' => ['required','string','max:80'], 'priority' => ['required','in:Low,Normal,High,Emergency']]);
        $property = Property::findOrFail($data['property_id']);
        if (!empty($data['unit_id'])) Unit::whereKey($data['unit_id'])->where('property_id', $property->id)->firstOrFail();
        $item = MaintenanceRequest::create($data + ['organization_id' => $property->organization_id, 'reported_by' => 'Staff']);
        User::where('organization_id', $property->organization_id)->get()->each(fn ($user) => $user->notify(new WorkspaceActivity('Maintenance request logged', "{$item->title} at {$property->name}.", 'bi-tools', route('maintenance.index'))));
        return back()->with('success', 'Maintenance request logged.');
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $data = $request->validate(['status' => ['required','in:Open,Assigned,Scheduled,In progress,Completed,Cancelled'], 'service_partner_id' => ['nullable','exists:service_partners,id'], 'quoted_amount' => ['nullable','numeric','min:0'], 'scheduled_for' => ['nullable','date']]);
        if ($data['service_partner_id'] ?? null) ServicePartner::availableForProperty($maintenance->property)->whereKey($data['service_partner_id'])->firstOrFail();
        $data['completed_at'] = $data['status'] === 'Completed' ? now() : null;
        $maintenance->update($data);
        return back()->with('success', 'Maintenance request updated.');
    }
}
