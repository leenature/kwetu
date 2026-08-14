<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = Carbon::parse($request->input('from', now()->startOfMonth()->toDateString()))->startOfDay();
        $to = Carbon::parse($request->input('to', now()->toDateString()))->endOfDay();
        $payments = Payment::with('lease.unit.property')->whereBetween('payment_date', [$from, $to]);
        $expenses = Expense::with('property')->whereBetween('expense_date', [$from, $to]);
        $income = (clone $payments)->sum('amount_paid');
        $spend = (clone $expenses)->where('status', 'Paid')->sum('amount');
        $byProperty = (clone $payments)->get()->groupBy(fn ($payment) => $payment->lease?->unit?->property?->name ?? 'Unassigned')
            ->map(fn ($items) => $items->sum('amount_paid'))->sortDesc();
        $expenseCategories = (clone $expenses)->where('status', 'Paid')->get()->groupBy('category')->map->sum('amount')->sortDesc();
        return view('reports.index', compact('from', 'to', 'income', 'spend', 'byProperty', 'expenseCategories'));
    }
}
