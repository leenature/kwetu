<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

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


        $recentPayments = Payment::with('lease.tenant')
                            ->latest()
                            ->limit(5)
                            ->get();


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
            'recentPayments'
        ));

    }
}