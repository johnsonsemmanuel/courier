<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $account = $user->accounts()->first();
        
        // Get recent transactions for display
        $recentTransactions = $account->transactions()
            ->latest()
            ->take(5)
            ->get();

        // Calculate actual monthly totals (current month)
        $startOfMonth = now()->startOfMonth();
        $monthlyIncome = $account->transactions()
            ->where('transaction_type', 'deposit')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('amount');

        $monthlyExpenses = $account->transactions()
            ->whereIn('transaction_type', ['withdrawal', 'transfer'])
            ->where('created_at', '>=', $startOfMonth)
            ->sum('amount');

        $monthlyTransactionCount = $account->transactions()
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        $pendingCount = $account->transactions()
            ->where('status', 'pending')
            ->count();

        // Get tax alert if exists
        $taxAlert = $user->taxAlert;

        // Calculate available balance (total - withheld)
        $availableBalance = $account->balance - ($account->withheld_amount ?? 0);

        // Get saved beneficiaries for quick transfer
        $savedBeneficiaries = $user->beneficiaries()
            ->where('is_favorite', true)
            ->take(3)
            ->get();

        // Get upcoming recurring transfers
        $upcomingTransfers = $user->recurringTransfers()
            ->where('status', 'active')
            ->where('next_execution_date', '>=', now())
            ->orderBy('next_execution_date')
            ->take(3)
            ->get();

        // Get active cards count
        $activeCardsCount = $user->cards()
            ->where('status', 'active')
            ->count();

        return view('dashboard.index', compact(
            'user',
            'account',
            'recentTransactions',
            'monthlyIncome',
            'monthlyExpenses',
            'monthlyTransactionCount',
            'pendingCount',
            'taxAlert',
            'availableBalance',
            'savedBeneficiaries',
            'upcomingTransfers',
            'activeCardsCount'
        ));
    }
}
