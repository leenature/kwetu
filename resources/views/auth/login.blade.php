@extends('layouts.auth')

@section('title', 'Log in — Kwetu PMS')

@section('content')

<div class="auth-card">
    <h1>Welcome back</h1>
    <p>Log in to manage your properties, tenants, and payments.</p>

    @if(session('status'))
        <div class="alert alert-success py-2">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email">Email address</label>
            <input id="email"
                   type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   autocomplete="username">

            @error('email')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between">
                <label for="password">Password</label>

                <a href="{{ route('password.request') }}"
                   class="text-decoration-none small"
                   style="color:#60a5fa;">
                    Forgot password?
                </a>
            </div>

            <input id="password"
                   type="password"
                   name="password"
                   class="form-control"
                   required
                   autocomplete="current-password">

            @error('password')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <label class="form-check mb-4">
            <input type="checkbox" name="remember" class="form-check-input">
            <span class="form-check-label text-light small">Keep me signed in</span>
        </label>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
            <i class="bi bi-box-arrow-in-right me-1"></i>
            Log in
        </button>
    </form>

    <p class="auth-footer">
        New to Kwetu?
        <a href="{{ route('register') }}">Start your free trial</a>
    </p>
</div>

@endsection