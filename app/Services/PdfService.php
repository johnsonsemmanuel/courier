<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Transaction;
use Carbon\Carbon;

class PdfService
{
    public function generateStatement(User $user, $startDate = null, $endDate = null)
    {
        $account = $user->accounts->first();
        
        $startDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->subMonth();
        $endDate = $endDate ? Carbon::parse($endDate) : Carbon::now();
        
        $transactions = Transaction::where('account_id', $account->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalDeposits = $transactions->where('transaction_type', 'deposit')->sum('amount');
        $totalWithdrawals = $transactions->whereIn('transaction_type', ['withdrawal', 'transfer'])->sum('amount');
        
        $data = [
            'user' => $user,
            'account' => $account,
            'transactions' => $transactions,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalDeposits' => $totalDeposits,
            'totalWithdrawals' => $totalWithdrawals,
            'generatedDate' => Carbon::now(),
        ];
        
        $pdf = Pdf::loadView('pdf.statement', $data);
        return $pdf->download('statement-' . $startDate->format('Y-m-d') . '-to-' . $endDate->format('Y-m-d') . '.pdf');
    }
    
    public function generateReceipt(Transaction $transaction)
    {
        $data = [
            'transaction' => $transaction,
            'account' => $transaction->account,
            'user' => $transaction->account->user,
            'generatedDate' => Carbon::now(),
        ];
        
        $pdf = Pdf::loadView('pdf.receipt', $data);
        return $pdf->download('receipt-' . $transaction->reference_number . '.pdf');
    }
}
