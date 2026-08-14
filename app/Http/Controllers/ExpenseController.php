<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Organization;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::with('property', 'unit')->latest('expense_date')->paginate(12);
        $properties = Property::orderBy('name')->get();
        $organizations = $request->user()->role === 'Super Admin' ? Organization::orderBy('name')->get() : collect();
        $monthTotal = Expense::where('status', 'Paid')->whereBetween('expense_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');
        $pendingTotal = Expense::where('status', 'Pending')->sum('amount');
        return view('expenses.index', compact('expenses', 'properties', 'organizations', 'monthTotal', 'pendingTotal'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id' => ['required', 'exists:properties,id'], 'unit_id' => ['nullable', 'exists:units,id'],
            'category' => ['required', 'string', 'max:100'], 'title' => ['required', 'string', 'max:150'],
            'amount' => ['required', 'numeric', 'min:0.01'], 'expense_date' => ['required', 'date'],
            'vendor' => ['nullable', 'string', 'max:150'], 'payment_method' => ['nullable', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:100'], 'status' => ['required', 'in:Pending,Paid,Cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
        $property = Property::findOrFail($data['property_id']);
        $organizationId = $request->user()->role === 'Super Admin' ? $property->organization_id : $request->user()->organization_id;
        abort_unless($organizationId && $property->organization_id === $organizationId, 422, 'The selected property does not belong to your workspace.');
        if (!empty($data['unit_id'])) abort_unless(Unit::whereKey($data['unit_id'])->where('property_id', $property->id)->exists(), 422, 'The selected unit does not belong to this property.');
        $data['organization_id'] = $organizationId;
        Expense::create($data);
        return back()->with('success', 'Expense saved successfully.');
    }

    public function updateStatus(Request $request, Expense $expense)
    {
        $expense->update($request->validate(['status' => ['required', 'in:Pending,Paid,Cancelled']]));
        return back()->with('success', 'Expense status updated.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success', 'Expense removed.');
    }
}
