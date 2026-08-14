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
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidenceController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LandingManagementController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\TenantPortalController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\ClientController;
Route::get('/properties/{property}/units', [UnitController::class, 'propertyUnits'])
    ->middleware(['auth', 'organization.active', 'module.permission:units'])
    ->name('properties.units');
 Route::get('/properties/{property}/available-units', [UnitController::class, 'availableUnits'])
    ->middleware(['auth', 'organization.active', 'module.permission:units'])
    ->name('properties.available-units');  
    Route::get('/', [LandingController::class, 'index'])->name('home');
    Route::get('/residences', [ResidenceController::class, 'index'])->name('residences.index');
    Route::get('/residences/{property}', [ResidenceController::class, 'show'])->name('residences.show');
    Route::get('/tenant-portal/{token}', [TenantPortalController::class, 'show'])->name('tenant-portal.show');
    Route::post('/tenant-portal/{token}/maintenance', [TenantPortalController::class, 'storeMaintenance'])->name('tenant-portal.maintenance.store');
    Route::get('/client-portal/{token}', [ClientController::class, 'portal'])->name('client-portal.show');
Route::middleware(['auth', 'organization.active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    Route::resource('organizations', OrganizationController::class)
        ->only(['index', 'show', 'edit', 'update']);

    Route::resource('users', UserManagementController::class)
        ->only(['index', 'create', 'store', 'update']);
    Route::get('/verification', [\App\Http\Controllers\PropertyVerificationController::class, 'index'])->name('verification.index');
    Route::patch('/verification/{property}', [\App\Http\Controllers\PropertyVerificationController::class, 'update'])->name('verification.update');

    // Resources
    Route::resource('properties', PropertyController::class)->middleware('module.permission:properties');
    Route::resource('units', UnitController::class)->middleware('module.permission:units');
    Route::resource('tenants', TenantController::class)->middleware('module.permission:tenants');
    Route::resource('leases', LeaseController::class)->middleware('module.permission:leases');
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->middleware('module.permission:maintenance')->name('maintenance.index');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->middleware('module.permission:maintenance')->name('maintenance.store');
    Route::patch('/maintenance/{maintenance}', [MaintenanceController::class, 'update'])->middleware('module.permission:maintenance')->name('maintenance.update');
    Route::get('/onboarding', [OnboardingController::class, 'index'])->name('onboarding.index');
    Route::get('/onboarding/template', [OnboardingController::class, 'template'])->name('onboarding.template');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

    // Other Modules
    Route::get('/payments', [PaymentController::class, 'index'])
        ->middleware('module.permission:payments')->name('payments.index');
    Route::post('/payments', [PaymentController::class, 'store'])
        ->middleware('module.permission:payments')->name('payments.store');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])
        ->middleware('module.permission:payments')->name('payments.destroy');

    Route::get('/expenses', [ExpenseController::class, 'index'])
        ->middleware('module.permission:expenses')->name('expenses.index');
    Route::post('/expenses', [ExpenseController::class, 'store'])
        ->middleware('module.permission:expenses')->name('expenses.store');
    Route::patch('/expenses/{expense}/status', [ExpenseController::class, 'updateStatus'])
        ->middleware('module.permission:expenses')->name('expenses.status');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])
        ->middleware('module.permission:expenses')->name('expenses.destroy');

    Route::get('/reports', [ReportController::class, 'index'])
        ->middleware('module.permission:reports')->name('reports.index');

    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings/landing', [LandingManagementController::class, 'index'])->name('settings.landing');
    Route::put('/settings/landing', [LandingManagementController::class, 'updateContent'])->name('settings.landing.update');
    Route::post('/settings/partners', [LandingManagementController::class, 'storePartner'])->name('settings.partners.store');
    Route::put('/settings/partners/{partner}', [LandingManagementController::class, 'updatePartner'])->name('settings.partners.update');
    Route::delete('/settings/partners/{partner}', [LandingManagementController::class, 'destroyPartner'])->name('settings.partners.destroy');
});

require __DIR__.'/auth.php';
