<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/organizations', [OrganizationController::class, 'index'])
        ->name('organizations.index');

    // Debug route (remove later)
    Route::get('/tenant/{tenant}', function ($tenant) {
        return \App\Models\Tenant::with('unit.property')
            ->findOrFail($tenant);
    });

    // Resources
    Route::resource('properties', PropertyController::class);
    Route::resource('units', UnitController::class);
    Route::resource('tenants', TenantController::class);
    Route::resource('leases', LeaseController::class);

    // Other Modules
    Route::get('/payments', [PaymentController::class, 'index'])
        ->name('payments.index');

    Route::get('/expenses', [ExpenseController::class, 'index'])
        ->name('expenses.index');

    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings.index');
});

require __DIR__.'/auth.php';