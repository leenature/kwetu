<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Organization;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('lease.tenant', 'lease.unit.property')->latest('payment_date')->paginate(12);
        $leases = Lease::with('tenant', 'unit.property')->where('status', 'Active')->orderByDesc('start_date')->get();
        $organizations = $request->user()->role === 'Super Admin' ? Organization::orderBy('name')->get() : collect();
        $monthTotal = Payment::whereBetween('payment_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount_paid');
        $total = Payment::sum('amount_paid');

        return view('payments.index', compact('payments', 'leases', 'organizations', 'monthTotal', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lease_id' => ['required', 'exists:leases,id'], 'payment_date' => ['required', 'date'],
            'amount_paid' => ['required', 'numeric', 'min:0.01'], 'payment_method' => ['required', 'in:Cash,M-Pesa,Bank Transfer,Cheque,Card,Other'],
            'payment_for' => ['required', 'string', 'max:100'], 'reference_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'], 'organization_id' => ['nullable', 'exists:organizations,id'],
        ]);
        $lease = Lease::findOrFail($data['lease_id']);
        $organizationId = $request->user()->role === 'Super Admin' ? $lease->organization_id : $request->user()->organization_id;
        abort_unless($organizationId && $lease->organization_id === $organizationId, 422, 'The selected lease does not belong to your workspace.');
        $data['organization_id'] = $organizationId;
        $data['receipt_number'] = 'KWT-' . now()->format('Ymd') . '-' . strtoupper(str()->random(6));
        Payment::create($data);
        return back()->with('success', 'Payment recorded and receipt generated.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return back()->with('success', 'Payment record removed.');
    }
}
