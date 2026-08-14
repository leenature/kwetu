<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use App\Notifications\WorkspaceActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyVerificationController extends Controller
{
    private function authorizeAdmin(): void { abort_unless(auth()->user()?->role === 'Super Admin', 403); }

    public function index(): View
    {
        $this->authorizeAdmin();
        $properties = Property::with(['organization', 'files'])->latest()->paginate(15);
        return view('verification.index', compact('properties'));
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validate([
            'verification_status' => ['required', 'in:Verified,Rejected,Pending Review'],
            'verification_notes' => ['nullable', 'string', 'max:2000'],
        ]);
        $property->update($data + ['reviewed_by' => $request->user()->id, 'reviewed_at' => now()]);
        User::where('organization_id', $property->organization_id)->where('role', 'Owner')->get()
            ->each(fn (User $owner) => $owner->notify(new WorkspaceActivity(
                'Property verification updated', "{$property->name} is now {$property->verification_status}.",
                $property->verification_status === 'Verified' ? 'bi-patch-check-fill' : 'bi-shield-exclamation',
                route('properties.show', $property),
            )));
        return back()->with('success', "{$property->name} verification status updated.");
    }
}
