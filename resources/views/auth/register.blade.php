@extends('layouts.auth')

@section('title', 'Start free trial — Kwetu PMS')

@section('content')

@php
    $plans = [
        'starter' => ['name' => 'Starter', 'price' => 'KSh 0 / month'],
        'growth' => ['name' => 'Growth', 'price' => 'KSh 2,500 / month'],
        'pro' => ['name' => 'Pro', 'price' => 'KSh 5,000 / month'],
    ];

    $plan = $plans[$selectedPlan] ?? $plans['starter'];
@endphp

<div class="auth-card">
    <h1>Start your free trial</h1>
    <p>
        Create your workspace and get 14 days of full access.
        No payment details required.
    </p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="organization_name">Organization name</label>
            <input id="organization_name"
                   type="text"
                   name="organization_name"
                   class="form-control"
                   value="{{ old('organization_name') }}"
                   placeholder="e.g. Kwetu Properties Ltd"
                   required
                   autofocus>

            @error('organization_name')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="account_type">I am registering as</label>
            <select id="account_type" name="account_type" class="form-select" required>
                <option value="solo_owner" @selected(old('account_type') === 'solo_owner')>Solo property owner</option>
                <option value="property_agent" @selected(old('account_type') === 'property_agent')>Property agent / management company</option>
            </select>
            <small class="d-block mt-1" style="color:#94a3b8;">Agents can manage portfolios on behalf of property owners.</small>
            @error('account_type')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label for="name">Your full name</label>
            <input id="name"
                   type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   required
                   autocomplete="name">

            @error('name')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email">Work email</label>
            <input id="email"
                   type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   required
                   autocomplete="email">

            @error('email')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="phone">Phone number</label>
            <input id="phone" type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. 0712 345 678" required autocomplete="tel">
            @error('phone')<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label for="plan">Choose a plan</label>

            <select id="plan" name="plan" class="form-select" required>
                @foreach($plans as $key => $details)
                    <option value="{{ $key }}"
                        @selected(old('plan', $selectedPlan) === $key)>
                        {{ $details['name'] }} — {{ $details['price'] }}
                    </option>
                @endforeach
            </select>

            <small class="d-block mt-1" style="color:#94a3b8;">
                Your 14-day trial starts immediately. You can change plans later.
            </small>

            @error('plan')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password">Password</label>
            <input id="password"
                   type="password"
                   name="password"
                   class="form-control"
                   required
                   autocomplete="new-password">

            @error('password')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   class="form-control"
                   required
                   autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
            <i class="bi bi-rocket-takeoff me-1"></i>
            Start 14-day free trial
        </button>
    </form>

    <p class="auth-footer">
        Already have an account?
        <a href="{{ route('login') }}">Log in</a>
    </p>
</div>

@endsection
