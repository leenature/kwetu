@extends('layouts.app')

@section('title', 'Add User')

@section('content')
<div class="properties-page user-management-page">
    <header class="module-header">
        <div>
            <a href="{{ route('users.index') }}" class="back-link"><i class="bi bi-arrow-left"></i> Users</a>
            <p class="module-eyebrow mt-3">Team access</p>
            <h1 class="module-title">Add a user</h1>
            <p class="module-subtitle">They will receive an email with their sign-in details.</p>
        </div>
    </header>

    <form method="POST" action="{{ route('users.store') }}" class="module-card subscription-form">
        @csrf
        <div class="row g-4">
            @if(auth()->user()->role === 'Super Admin')
                <div class="col-12">
                    <label class="form-label" for="organization_id">Organization</label>
                    <select class="form-select @error('organization_id') is-invalid @enderror" name="organization_id" id="organization_id" required>
                        <option value="">Select the organization</option>
                        @foreach($organizations as $organization)<option value="{{ $organization->id }}" @selected(old('organization_id') == $organization->id)>{{ $organization->name }}</option>@endforeach
                    </select>
                    @error('organization_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            @endif
            <div class="col-md-6">
                <label class="form-label" for="name">Full name</label>
                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="email">Email address</label>
                <input class="form-control @error('email') is-invalid @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="role">Role</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="">Select role</option>
                    @foreach($roles as $role)<option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>@endforeach
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 d-flex align-items-end"><div class="access-note"><i class="bi bi-info-circle-fill"></i> Roles control the user’s workspace access.</div></div>
            @if(auth()->user()->role !== 'Super Admin')
                <div class="col-12"><label class="form-label">Workspace permissions</label><p class="small text-secondary">Choose the areas this staff member can use. Owners always keep full access.</p><div class="d-flex flex-wrap gap-3">@foreach(\App\Http\Controllers\UserManagementController::MODULES as $module)<label class="form-check"><input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $module }}" @checked(in_array($module, old('permissions', [])))> {{ ucfirst($module) }}</label>@endforeach</div></div>
            @endif
            <div class="col-md-6">
                <label class="form-label" for="password">Initial password</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password" name="password" required autocomplete="new-password">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="password_confirmation">Confirm password</label>
                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>
        <p class="credential-note mt-4 mb-0"><i class="bi bi-envelope-check-fill"></i> The email includes the user’s email address, initial password, and the Kwetu login link.</p>
        <div class="d-flex gap-3 justify-content-end mt-5"><a href="{{ route('users.index') }}" class="btn btn-light border px-4">Cancel</a><button class="btn btn-primary px-4" type="submit"><i class="bi bi-send-fill me-1"></i> Create and email credentials</button></div>
    </form>
</div>
@endsection
