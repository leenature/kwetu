<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\Organization;

class DashboardController extends Controller
{
    public function index()
    {
        $isSuperAdmin = auth()->user()->role === 'Super Admin';

        $properties = Property::count();

        $units = Unit::count();

        $occupiedUnits = Unit::where('status','Occupied')->count();

        $vacantUnits = Unit::where('status','Vacant')->count();


        $tenants = Tenant::count();


        $activeLeases = Lease::where('status','Active')->count();


        $expectedRent = Lease::where('status','Active')
                            ->sum('rent_amount');


        $collectedThisMonth = Payment::whereMonth(
                                'payment_date',
                                now()->month
                            )
                            ->whereYear(
                                'payment_date',
                                now()->year
                            )
                            ->sum('amount_paid');


        $outstanding = $expectedRent - $collectedThisMonth;
        $totalExpenses = Expense::sum('amount');

        $profit = $collectedThisMonth - $totalExpenses;

        $occupancyRate = $units > 0 ? round(($occupiedUnits / $units) * 100, 1) : 0;


        $recentPayments = Payment::with('lease.tenant')
                            ->latest()
                            ->limit(5)
                            ->get();

$monthlyRevenue = Payment::selectRaw("
        MONTH(payment_date) as month,
        SUM(amount_paid) as total
    ")
    ->whereYear('payment_date', now()->year)
    ->groupBy('month')
    ->orderBy('month')
    ->pluck('total','month');


$revenueMonths = [];

$revenueValues = [];


foreach($monthlyRevenue as $month=>$amount){

    $revenueMonths[] = date("M", mktime(0,0,0,$month,1));

    $revenueValues[] = $amount;

}

        $subscriptionOrganizations = $isSuperAdmin
            ? Organization::query()
                ->with(['users:id,organization_id,name,email'])
                ->withCount('properties')
                ->latest()
                ->limit(8)
                ->get()
            : collect();

        $subscriptionMetrics = collect();
        if ($isSuperAdmin) {
            $prices = ['starter' => 0, 'growth' => 2500, 'pro' => 5000];
            $subscriptionMetrics = Organization::query()
                ->selectRaw('plan, count(*) as total')
                ->whereIn('subscription_status', ['trialing', 'active'])
                ->groupBy('plan')
                ->pluck('total', 'plan');
            $expectedSubscriptionRevenue = $subscriptionMetrics
                ->map(fn ($count, $plan) => $count * ($prices[$plan] ?? 0))
                ->sum();
            $activeSubscriptions = $subscriptionMetrics->sum();
        } else {
            $expectedSubscriptionRevenue = 0;
            $activeSubscriptions = 0;
        }

        $mapProperties = Property::query()->whereNotNull('latitude')->whereNotNull('longitude')
            ->get(['id', 'name', 'town', 'county', 'latitude', 'longitude', 'status']);

        return view('dashboard.index', compact(
            'properties',
            'units',
            'occupiedUnits',
            'vacantUnits',
            'tenants',
            'activeLeases',
            'expectedRent',
            'collectedThisMonth',
            'outstanding',
            'recentPayments',
            'totalExpenses',
            'profit',
            'occupancyRate',
            'revenueMonths',
            'revenueValues',
            'isSuperAdmin',
            'subscriptionOrganizations',
            'mapProperties',
            'subscriptionMetrics',
            'expectedSubscriptionRevenue',
            'activeSubscriptions',
        ));

    }
}
