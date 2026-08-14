@extends('layouts.app')

@section('title', 'Manage '.$organization->name)

@section('content')
<div class="properties-page organization-page">
    <header class="module-header">
        <div>
            <a href="{{ route('organizations.show', $organization) }}" class="back-link"><i class="bi bi-arrow-left"></i> {{ $organization->name }}</a>
            <p class="module-eyebrow mt-3">Super Admin controls</p>
            <h1 class="module-title">Manage subscription</h1>
            <p class="module-subtitle">Update this organization’s access and billing state.</p>
        </div>
    </header>

    <form method="POST" action="{{ route('organizations.update', $organization) }}" class="module-card subscription-form">
        @csrf
        @method('PATCH')

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label" for="plan">Package</label>
                <select class="form-select @error('plan') is-invalid @enderror" id="plan" name="plan">
                    @foreach(['starter' => 'Starter', 'growth' => 'Growth', 'pro' => 'Pro'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('plan', $organization->plan) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('plan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="subscription_status">Subscription status</label>
                <select class="form-select @error('subscription_status') is-invalid @enderror" id="subscription_status" name="subscription_status">
                    @foreach(['trialing' => 'Trialing', 'active' => 'Active', 'expired' => 'Expired', 'cancelled' => 'Cancelled'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('subscription_status', $organization->subscription_status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('subscription_status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="trial_ends_at">Trial end date</label>
                <input class="form-control @error('trial_ends_at') is-invalid @enderror" type="date" id="trial_ends_at" name="trial_ends_at" value="{{ old('trial_ends_at', $organization->trial_ends_at?->format('Y-m-d')) }}">
                <div class="form-text">Leave blank when this account is no longer on a trial.</div>
                @error('trial_ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label" for="status">Account access</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                    @foreach(['Active', 'Inactive'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $organization->status) === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <div class="form-text">Inactive organizations remain visible to Super Admin but should not be allowed to use the app.</div>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="d-flex gap-3 justify-content-end mt-5">
            <a href="{{ route('organizations.show', $organization) }}" class="btn btn-light border px-4">Cancel</a>
            <button class="btn btn-primary px-4" type="submit"><i class="bi bi-check2-circle me-1"></i> Save changes</button>
        </div>
    </form>
</div>
@endsection
