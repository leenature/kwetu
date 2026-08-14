<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrganizationController extends Controller
{
    private function ensureSuperAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'Super Admin', 403);
    }

    public function index()
    {
        $this->ensureSuperAdmin();

        $organizations = Organization::query()
            ->with(['users:id,organization_id,name,email,role'])
            ->withCount(['properties', 'tenants'])
            ->latest()
            ->paginate(12);

        return view('organizations.index', compact('organizations'));
    }

    public function show(Organization $organization)
    {
        $this->ensureSuperAdmin();

        $organization->load([
            'users:id,organization_id,name,email,role,created_at',
            'properties' => fn ($query) => $query->withCount('units')->latest(),
        ])->loadCount(['properties', 'tenants']);

        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        $this->ensureSuperAdmin();

        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'plan' => ['required', Rule::in(['starter', 'growth', 'pro'])],
            'subscription_status' => ['required', Rule::in(['trialing', 'active', 'expired', 'cancelled'])],
            'trial_ends_at' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $organization->update($validated);

        return redirect()
            ->route('organizations.show', $organization)
            ->with('success', 'Organization subscription updated successfully.');
    }
}
