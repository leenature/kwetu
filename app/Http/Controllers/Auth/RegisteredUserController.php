<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    private const PLANS = [
        'starter' => 'Starter',
        'growth' => 'Growth',
        'pro' => 'Pro',
    ];

    public function create(Request $request): View
    {
        $selectedPlan = $request->query('plan', 'starter');

        if (! array_key_exists($selectedPlan, self::PLANS)) {
            $selectedPlan = 'starter';
        }

        return view('auth.register', compact('selectedPlan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'account_type' => ['required', Rule::in(['solo_owner', 'property_agent'])],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'plan' => ['required', Rule::in(array_keys(self::PLANS))],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $organization = Organization::create([
                'name' => $validated['organization_name'],
                'account_type' => $validated['account_type'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'status' => 'Active',
                'plan' => $validated['plan'],
                'subscription_status' => 'trialing',
                'trial_ends_at' => now()->addDays(14),
            ]);

            return User::create([
                'organization_id' => $organization->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'Owner',
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Welcome to Kwetu! Your 14-day free trial has started.');
    }
}
