@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="properties-page user-management-page">
    <header class="module-header">
        <div>
            <p class="module-eyebrow">{{ auth()->user()->role === 'Super Admin' ? 'System access' : 'Team management' }}</p>
            <h1 class="module-title">Users</h1>
            <p class="module-subtitle">{{ auth()->user()->role === 'Super Admin' ? 'Create and manage users across customer organizations.' : 'Invite staff to help manage your properties.' }}</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary px-3 py-2"><i class="bi bi-person-plus-fill me-1"></i> Add user</a>
    </header>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('warning') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="module-card organization-table-card">
        <div class="table-responsive">
            <table class="table modern-table align-middle mb-0">
                <thead><tr><th>User</th>@if(auth()->user()->role === 'Super Admin')<th>Organization</th>@endif<th>Role</th><th>Joined</th><th>Access</th></tr></thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td><div class="d-flex align-items-center gap-2"><span class="user-initial">{{ strtoupper(substr($user->name, 0, 1)) }}</span><div><strong>{{ $user->name }}</strong><small class="d-block text-secondary">{{ $user->email }}</small></div></div></td>
                            @if(auth()->user()->role === 'Super Admin')<td>{{ $user->organization?->name ?? 'Kwetu system' }}</td>@endif
                            <td><span class="role-label">{{ $user->role }}</span></td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>@if($user->role !== 'Super Admin' && ($user->role !== 'Owner' || auth()->user()->role === 'Super Admin'))<details><summary class="btn btn-sm btn-outline-primary">Edit role & access</summary><form method="POST" action="{{ route('users.update', $user) }}" class="mt-2">@csrf @method('PUT')<label class="form-label small">Role</label><select name="role" class="form-select form-select-sm mb-2">@foreach(auth()->user()->role === 'Super Admin' ? ['Owner','Manager','Accountant','Caretaker'] : ['Manager','Accountant','Caretaker'] as $role)<option value="{{ $role }}" @selected($user->role === $role)>{{ $role }}</option>@endforeach</select><div class="d-flex flex-wrap gap-2">@foreach(\App\Http\Controllers\UserManagementController::MODULES as $module)<label class="form-check small"><input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $module }}" @checked(in_array($module, $user->permissions ?? []))> {{ ucfirst($module) }}</label>@endforeach</div><button class="btn btn-sm btn-primary mt-2">Save changes</button></form></details>@else<span class="text-secondary small">Protected system access</span>@endif</td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ auth()->user()->role === 'Super Admin' ? 4 : 4 }}" class="text-center py-5 text-secondary">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())<div class="pt-4">{{ $users->links() }}</div>@endif
    </div>
</div>
@endsection
