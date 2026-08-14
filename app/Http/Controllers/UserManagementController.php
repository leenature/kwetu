<?php

namespace App\Http\Controllers;

use App\Mail\NewUserCredentialsMail;
use App\Models\Organization;
use App\Models\User;
use App\Notifications\WorkspaceActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    private const STAFF_ROLES = ['Manager', 'Accountant', 'Caretaker'];
    private const ADMIN_ROLES = ['Owner', 'Manager', 'Accountant', 'Caretaker'];
    public const MODULES = ['properties', 'units', 'tenants', 'leases', 'payments', 'expenses', 'reports'];

    private function authorizeManagement(): void
    {
        abort_unless(in_array(auth()->user()?->role, ['Super Admin', 'Owner'], true), 403);
    }

    private function availableRoles(): array
    {
        return auth()->user()->role === 'Super Admin'
            ? self::ADMIN_ROLES
            : self::STAFF_ROLES;
    }

    public function index(): View
    {
        $this->authorizeManagement();

        $query = User::with('organization')->latest();

        if (auth()->user()->role !== 'Super Admin') {
            $query->where('organization_id', auth()->user()->organization_id);
        }

        $users = $query->paginate(12);

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $this->authorizeManagement();

        $organizations = auth()->user()->role === 'Super Admin'
            ? Organization::orderBy('name')->get(['id', 'name'])
            : collect();

        $roles = $this->availableRoles();

        return view('users.create', compact('organizations', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeManagement();

        $isSuperAdmin = auth()->user()->role === 'Super Admin';
        $roles = $this->availableRoles();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in($roles)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'organization_id' => [$isSuperAdmin ? 'required' : 'nullable', 'integer', 'exists:organizations,id'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(self::MODULES)],
        ]);

        $organizationId = $isSuperAdmin
            ? $validated['organization_id']
            : auth()->user()->organization_id;

        abort_unless($organizationId, 422, 'The current user has no organization.');

        $initialPassword = $validated['password'];

        $user = User::create([
            'organization_id' => $organizationId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($initialPassword),
            'permissions' => $validated['permissions'] ?? null,
        ]);

        User::where('organization_id', $organizationId)->get()
            ->each(fn (User $recipient) => $recipient->notify(new WorkspaceActivity(
                'New user created', "{$user->name} joined as {$user->role}.",
                'bi-person-plus-fill', route('users.index'),
            )));

        try {
            Mail::to($user->email)->send(new NewUserCredentialsMail($user, $initialPassword));
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()
                ->route('users.index')
                ->with('success', 'User created successfully.')
                ->with('warning', 'The user was created, but the email could not be sent. Check your mail settings.');
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User created and login credentials were emailed successfully.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorizeManagement();
        abort_unless($user->role !== 'Super Admin', 403, 'Super Admin access cannot be changed here.');
        abort_unless($user->role !== 'Owner' || auth()->user()->role === 'Super Admin', 403, 'Owner access cannot be changed here.');
        if (auth()->user()->role !== 'Super Admin') {
            abort_unless($user->organization_id === auth()->user()->organization_id, 403);
        }
        $validated = $request->validate([
            'role' => ['required', Rule::in($this->availableRoles())],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(self::MODULES)],
        ]);
        $user->update(['role' => $validated['role'], 'permissions' => $validated['permissions'] ?? []]);
        return back()->with('success', "Access updated for {$user->name}.");
    }
}
