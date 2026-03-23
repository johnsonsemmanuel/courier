<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $account = $user->accounts()->first();
        
        $query = $account->transactions()->latest();

        // Filter by transaction type
        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('transaction_type', $request->type);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by reference number
        if ($request->filled('search')) {
            $query->where('reference_number', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    public function showSendMoney()
    {
        return view('transactions.send-money');
    }

    public function sendMoney(Request $request)
    {
        $validated = $request->validate([
            'recipient_account' => 'required|string|exists:accounts,account_number',
            'recipient_name' => 'required|string',
            'amount' => 'required|numeric|min:1|max:50000',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $taxAlert = $user->taxAlert;

        // Check for IRS tax obligations
        if ($taxAlert && $taxAlert->has_tax_obligation) {
            return back()->with('error', 'You have pending tax obligations with the IRS. Please contact customer support before proceeding with this transaction.');
        }

        $account = $user->accounts()->first();

        // Prevent self-transfer
        if ($validated['recipient_account'] === $account->account_number) {
            return back()->with('error', 'You cannot transfer money to your own account.');
        }

        if ($account->balance < $validated['amount']) {
            return back()->with('error', 'Insufficient balance.');
        }

        // Get recipient account
        $recipientAccount = Account::where('account_number', $validated['recipient_account'])->first();

        DB::transaction(function () use ($account, $recipientAccount, $validated) {
            // Deduct from sender
            $account->decrement('balance', $validated['amount']);

            // Add to recipient
            $recipientAccount->increment('balance', $validated['amount']);

            // Create transaction record for sender
            Transaction::create([
                'account_id' => $account->id,
                'transaction_type' => 'transfer',
                'amount' => $validated['amount'],
                'recipient_account' => $validated['recipient_account'],
                'recipient_name' => $validated['recipient_name'],
                'description' => $validated['description'],
                'status' => 'completed',
                'reference_number' => 'TXN' . strtoupper(Str::random(12)),
            ]);

            // Create transaction record for recipient
            Transaction::create([
                'account_id' => $recipientAccount->id,
                'transaction_type' => 'deposit',
                'amount' => $validated['amount'],
                'description' => 'Transfer from ' . $account->account_number,
                'status' => 'completed',
                'reference_number' => 'TXN' . strtoupper(Str::random(12)),
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Money sent successfully!');
    }

    public function showDeposit()
    {
        return view('transactions.deposit');
    }

    public function deposit(Request $request)
    {
        $user = Auth::user();
        $taxAlert = $user->taxAlert;

        // Check for IRS tax obligations
        if ($taxAlert && $taxAlert->has_tax_obligation) {
            return back()->with('error', 'Deposits are blocked due to pending IRS tax obligations. Please contact support@couriersavingsbank.com for assistance.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'payment_method' => 'nullable|string|in:stripe,bank_transfer,test',
        ]);

        $account = $user->accounts()->first();
        
        $paymentMethod = $validated['payment_method'] ?? 'test';
        $description = $validated['description'] ?? 'Deposit via ' . ucfirst(str_replace('_', ' ', $paymentMethod));

        DB::transaction(function () use ($account, $validated, $description, $paymentMethod) {
            $account->increment('balance', $validated['amount']);

            Transaction::create([
                'account_id' => $account->id,
                'transaction_type' => 'deposit',
                'amount' => $validated['amount'],
                'description' => $description,
                'status' => 'completed',
                'reference_number' => 'TXN' . strtoupper(Str::random(12)),
                'payment_method' => $paymentMethod,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Deposit successful! Funds have been added to your account.');
    }

    public function depositStripe(Request $request)
    {
        $user = Auth::user();
        $taxAlert = $user->taxAlert;

        // Check for IRS tax obligations
        if ($taxAlert && $taxAlert->has_tax_obligation) {
            return back()->with('error', 'Deposits are blocked due to pending IRS tax obligations. Please contact support@couriersavingsbank.com for assistance.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        // In production, this would integrate with Stripe API
        // For demo purposes, we'll simulate a successful payment
        
        $account = $user->accounts()->first();
        
        $description = $validated['description'] ?? 'Deposit via Stripe';

        DB::transaction(function () use ($account, $validated, $description) {
            $account->increment('balance', $validated['amount']);

            Transaction::create([
                'account_id' => $account->id,
                'transaction_type' => 'deposit',
                'amount' => $validated['amount'],
                'description' => $description,
                'status' => 'completed',
                'reference_number' => 'TXN' . strtoupper(Str::random(12)),
                'payment_method' => 'stripe',
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Payment processed successfully! Funds have been added to your account.');
    }

    public function depositBank(Request $request)
    {
        $user = Auth::user();
        $taxAlert = $user->taxAlert;

        // Check for IRS tax obligations
        if ($taxAlert && $taxAlert->has_tax_obligation) {
            return back()->with('error', 'Deposits are blocked due to pending IRS tax obligations. Please contact support@couriersavingsbank.com for assistance.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        $account = $user->accounts()->first();
        
        $description = $validated['description'] ?? 'Bank transfer deposit (pending verification)';

        // Bank transfers are marked as pending until admin verifies
        Transaction::create([
            'account_id' => $account->id,
            'transaction_type' => 'deposit',
            'amount' => $validated['amount'],
            'description' => $description,
            'status' => 'pending',
            'reference_number' => 'TXN' . strtoupper(Str::random(12)),
            'payment_method' => 'bank_transfer',
        ]);

        return redirect()->route('dashboard')->with('success', 'Bank transfer request submitted! Your deposit will be processed within 1-3 business days after verification. Please ensure you use your User ID (' . $user->user_id . ') as the transfer reference.');
    }

    public function showWithdraw()
    {
        return view('transactions.withdraw');
    }

    public function withdraw(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:10000',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $account = $user->accounts()->first();

        if ($account->balance < $validated['amount']) {
            return back()->with('error', 'Insufficient balance.');
        }

        // Check daily withdrawal limit
        $todayWithdrawals = Transaction::where('account_id', $account->id)
            ->where('transaction_type', 'withdrawal')
            ->whereDate('created_at', today())
            ->sum('amount');

        if ($todayWithdrawals + $validated['amount'] > 10000) {
            return back()->with('error', 'Daily withdrawal limit of $10,000 exceeded.');
        }

        DB::transaction(function () use ($account, $validated) {
            $account->decrement('balance', $validated['amount']);

            Transaction::create([
                'account_id' => $account->id,
                'transaction_type' => 'withdrawal',
                'amount' => $validated['amount'],
                'description' => $validated['description'],
                'status' => 'completed',
                'reference_number' => 'TXN' . strtoupper(Str::random(12)),
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Withdrawal successful!');
    }
}
