<?php

namespace App\Http\Controllers;

use App\Models\BillPayee;
use App\Models\BillPayment;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BillPaymentController extends Controller
{
    // Payees Management
    public function payees()
    {
        $payees = auth()->user()->billPayees()->latest()->get();
        return view('bills.payees', compact('payees'));
    }

    public function createPayee()
    {
        return view('bills.create-payee');
    }

    public function storePayee(Request $request)
    {
        $validated = $request->validate([
            'payee_name' => 'required|string|max:255',
            'payee_type' => 'required|in:utility,telecom,subscription,insurance,education,other',
            'account_number' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        BillPayee::create($validated);

        return redirect()->route('bills.payees')->with('success', 'Payee added successfully!');
    }

    public function editPayee(BillPayee $payee)
    {
        $this->authorize('update', $payee);
        return view('bills.edit-payee', compact('payee'));
    }

    public function updatePayee(Request $request, BillPayee $payee)
    {
        $this->authorize('update', $payee);

        $validated = $request->validate([
            'payee_name' => 'required|string|max:255',
            'payee_type' => 'required|in:utility,telecom,subscription,insurance,education,other',
            'account_number' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
        ]);

        $payee->update($validated);

        return redirect()->route('bills.payees')->with('success', 'Payee updated successfully!');
    }

    public function destroyPayee(BillPayee $payee)
    {
        $this->authorize('delete', $payee);
        $payee->delete();

        return redirect()->route('bills.payees')->with('success', 'Payee deleted successfully!');
    }

    public function toggleFavorite(BillPayee $payee)
    {
        $this->authorize('update', $payee);
        $payee->update(['is_favorite' => !$payee->is_favorite]);

        return back()->with('success', 'Favorite status updated!');
    }

    // Bill Payments
    public function index()
    {
        $payments = auth()->user()->billPayments()->with('payee')->latest()->paginate(20);
        return view('bills.index', compact('payments'));
    }

    public function create()
    {
        $account = auth()->user()->accounts()->first();
        $payees = auth()->user()->billPayees()->get();
        
        return view('bills.create', compact('account', 'payees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bill_payee_id' => 'nullable|exists:bill_payees,id',
            'payee_name' => 'required|string|max:255',
            'payee_type' => 'required|in:utility,telecom,subscription,insurance,education,other',
            'account_number' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $account = auth()->user()->accounts()->first();

        if (!$account) {
            return back()->with('error', 'No account found.');
        }

        if ($account->balance < $validated['amount']) {
            return back()->with('error', 'Insufficient balance.');
        }

        DB::beginTransaction();
        try {
            // Create bill payment
            $payment = BillPayment::create([
                'user_id' => auth()->id(),
                'bill_payee_id' => $validated['bill_payee_id'],
                'account_id' => $account->id,
                'payee_name' => $validated['payee_name'],
                'payee_type' => $validated['payee_type'],
                'account_number' => $validated['account_number'],
                'provider' => $validated['provider'],
                'amount' => $validated['amount'],
                'reference_number' => 'BILL-' . strtoupper(Str::random(10)),
                'status' => 'completed',
                'notes' => $validated['notes'],
                'paid_at' => now(),
            ]);

            // Deduct from account
            $account->decrement('balance', $validated['amount']);

            // Create transaction record
            Transaction::create([
                'account_id' => $account->id,
                'type' => 'bill_payment',
                'amount' => $validated['amount'],
                'balance_after' => $account->fresh()->balance,
                'description' => "Bill payment to {$validated['provider']} - {$validated['payee_name']}",
                'reference_number' => $payment->reference_number,
                'status' => 'completed',
            ]);

            DB::commit();

            return redirect()->route('bills.index')->with('success', 'Bill payment successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Payment failed. Please try again.');
        }
    }

    public function show(BillPayment $payment)
    {
        $this->authorize('view', $payment);
        return view('bills.show', compact('payment'));
    }
}
