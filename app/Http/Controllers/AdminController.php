<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Models\Transaction;
use App\Models\TaxAlert;
use App\Notifications\AdminProvisionedAccountNotification;
use App\Notifications\TaxAlertNotification;
use App\Notifications\AccountFrozenNotification;
use App\Notifications\TransactionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTransactions = Transaction::count();
        $totalBalance = User::with('accounts')->get()->sum(function ($user) {
            return $user->accounts->sum('balance');
        });
        $pendingTaxAlerts = TaxAlert::where('has_tax_obligation', true)->count();

        $recentTransactions = Transaction::with('account.user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTransactions',
            'totalBalance',
            'pendingTaxAlerts',
            'recentTransactions'
        ));
    }

    public function users()
    {
        $users = User::with(['accounts', 'taxAlert'])->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function createUserForm()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $autoPassword = $request->boolean('auto_generate_password');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:255',
            'address' => 'required|string',
            'is_admin' => 'nullable|boolean',
            'initial_balance' => 'nullable|numeric|min:0',
            'send_welcome_email' => 'nullable|boolean',
        ];

        if (! $autoPassword) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        $plainPassword = $autoPassword ? Str::password(12) : $request->string('password')->toString();
        $sendWelcome = $request->boolean('send_welcome_email');

        $user = DB::transaction(function () use ($request, $validated, $plainPassword) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($plainPassword),
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'user_id' => $this->generateUniqueUserId(),
                'is_admin' => $request->boolean('is_admin'),
            ]);

            $account = Account::create([
                'user_id' => $user->id,
                'account_number' => $this->generateUniqueAccountNumber(),
                'account_name' => $validated['name'] . ' - Savings Account',
                'account_type' => 'savings',
                'balance' => 0,
                'status' => 'active',
            ]);

            $initial = (float) ($validated['initial_balance'] ?? 0);
            if ($initial > 0) {
                $account->increment('balance', $initial);
                Transaction::create([
                    'account_id' => $account->id,
                    'transaction_type' => 'deposit',
                    'amount' => $initial,
                    'description' => 'Opening deposit (admin provisioned account)',
                    'status' => 'completed',
                    'reference_number' => 'OPN' . strtoupper(Str::random(12)),
                ]);
            }

            return $user;
        });

        if ($sendWelcome) {
            try {
                $user->notify(new AdminProvisionedAccountNotification($plainPassword));
            } catch (\Throwable $e) {
                report($e);

                return redirect()
                    ->route('admin.users')
                    ->with('warning', 'User created, but the email could not be sent. Check SMTP settings in .env. Share login details with the user through a secure channel.');
            }
        }

        return redirect()
            ->route('admin.users')
            ->with('success', 'User account created successfully.');
    }

    private function generateUniqueUserId(): string
    {
        do {
            $userId = 'USR' . str_pad((string) random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (User::where('user_id', $userId)->exists());

        return $userId;
    }

    private function generateUniqueAccountNumber(): string
    {
        do {
            $accountNumber = str_pad((string) random_int(1000000000, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (Account::where('account_number', $accountNumber)->exists());

        return $accountNumber;
    }

    public function manageTaxAlert(Request $request, User $user)
    {
        $validated = $request->validate([
            'has_tax_obligation' => 'required|boolean',
            'tax_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $user->taxAlert()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        // Send notification to user
        $user->notify(new TaxAlertNotification(
            $validated['has_tax_obligation'],
            $validated['tax_amount'] ?? null,
            $validated['notes'] ?? null
        ));

        return back()->with('success', 'Tax alert updated and user notified via email');
    }

    public function addFunds(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ]);

        $account = $user->accounts()->first();
        
        if (!$account) {
            return back()->with('error', 'User has no account');
        }

        DB::transaction(function () use ($account, $validated) {
            $account->increment('balance', $validated['amount']);

            Transaction::create([
                'account_id' => $account->id,
                'transaction_type' => 'deposit',
                'amount' => $validated['amount'],
                'description' => 'Admin deposit: ' . ($validated['notes'] ?? 'Funds added by admin'),
                'status' => 'completed',
                'reference_number' => 'ADM' . strtoupper(Str::random(12)),
            ]);
        });

        return back()->with('success', 'Funds added successfully');
    }

    public function freezeAccount(User $user)
    {
        $account = $user->accounts()->first();
        
        if (!$account) {
            return back()->with('error', 'User has no account');
        }

        $account->update(['status' => 'frozen']);

        // Send notification to user
        $user->notify(new AccountFrozenNotification(true, 'Administrative action'));

        return back()->with('success', 'Account frozen and user notified via email');
    }

    public function unfreezeAccount(User $user)
    {
        $account = $user->accounts()->first();
        
        if (!$account) {
            return back()->with('error', 'User has no account');
        }

        $account->update(['status' => 'active']);

        // Send notification to user
        $user->notify(new AccountFrozenNotification(false));

        return back()->with('success', 'Account unfrozen and user notified via email');
    }

    public function withholdFunds(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'reason' => 'nullable|string',
        ]);

        $account = $user->accounts()->first();
        
        if (!$account) {
            return back()->with('error', 'User has no account');
        }

        if ($account->balance < $validated['amount']) {
            return back()->with('error', 'Insufficient balance to withhold');
        }

        DB::transaction(function () use ($account, $validated) {
            $account->decrement('balance', $validated['amount']);
            $account->increment('withheld_amount', $validated['amount']);

            Transaction::create([
                'account_id' => $account->id,
                'transaction_type' => 'withdrawal',
                'amount' => $validated['amount'],
                'description' => 'Funds withheld by admin: ' . ($validated['reason'] ?? 'Administrative hold'),
                'status' => 'completed',
                'reference_number' => 'WHD' . strtoupper(Str::random(12)),
            ]);
        });

        return back()->with('success', 'Funds withheld successfully');
    }

    public function releaseFunds(Request $request, User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $account = $user->accounts()->first();
        
        if (!$account) {
            return back()->with('error', 'User has no account');
        }

        if ($account->withheld_amount < $validated['amount']) {
            return back()->with('error', 'Insufficient withheld funds');
        }

        DB::transaction(function () use ($account, $validated) {
            $account->increment('balance', $validated['amount']);
            $account->decrement('withheld_amount', $validated['amount']);

            Transaction::create([
                'account_id' => $account->id,
                'transaction_type' => 'deposit',
                'amount' => $validated['amount'],
                'description' => 'Withheld funds released by admin',
                'status' => 'completed',
                'reference_number' => 'REL' . strtoupper(Str::random(12)),
            ]);
        });

        return back()->with('success', 'Funds released successfully');
    }
}
