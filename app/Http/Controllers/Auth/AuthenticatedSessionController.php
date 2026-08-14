<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\WorkspaceActivity;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();
        $recipients = $user->role === 'Super Admin'
            ? collect([$user])
            : User::where('organization_id', $user->organization_id)->where('role', 'Owner')->get()->push($user)->unique('id');

        $recipients->each(fn (User $recipient) => $recipient->notify(new WorkspaceActivity(
            'User signed in', "{$user->name} signed in to the workspace.",
            'bi-box-arrow-in-right', route('dashboard'),
        )));

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

       return redirect()->route('home');
    }
}
