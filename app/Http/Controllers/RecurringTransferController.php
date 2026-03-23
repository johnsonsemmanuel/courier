<?php

namespace App\Http\Controllers;

use App\Models\RecurringTransfer;
use App\Models\Account;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RecurringTransferController extends Controller
{
    public function index()
    {
        $recurringTransfers = auth()->user()->recurringTransfers()
            ->orderBy('next_execution_date', 'asc')
            ->get();
            
        return view('recurring-transfers.index', compact('recurringTransfers'));
    }

    public function create()
    {
        $beneficiaries = auth()->user()->beneficiaries;
        return view('recurring-transfers.create', compact('beneficiaries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipient_account' => 'required|string|max:20',
            'recipient_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:1|max:50000',
            'frequency' => 'required|in:daily,weekly,biweekly,monthly,quarterly,yearly',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'max_executions' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        // Verify recipient account exists
        $recipientAccount = Account::where('account_number', $request->recipient_account)->first();
        if (!$recipientAccount) {
            return back()->withErrors(['recipient_account' => 'Recipient account not found.'])->withInput();
        }

        // Prevent self-transfer
        if ($recipientAccount->user_id === auth()->id()) {
            return back()->withErrors(['recipient_account' => 'You cannot set up recurring transfers to yourself.'])->withInput();
        }

        // Check user balance
        $userAccount = auth()->user()->accounts->first();
        if ($userAccount->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient balance for the first transfer.'])->withInput();
        }

        auth()->user()->recurringTransfers()->create([
            'recipient_account' => $request->recipient_account,
            'recipient_name' => $request->recipient_name,
            'amount' => $request->amount,
            'frequency' => $request->frequency,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'next_execution_date' => $request->start_date,
            'description' => $request->description,
            'max_executions' => $request->max_executions,
            'status' => 'active',
        ]);

        return redirect()->route('recurring-transfers.index')
            ->with('success', 'Recurring transfer created successfully!');
    }

    public function show(RecurringTransfer $recurringTransfer)
    {
        $this->authorize('view', $recurringTransfer);
        return view('recurring-transfers.show', compact('recurringTransfer'));
    }

    public function pause(RecurringTransfer $recurringTransfer)
    {
        $this->authorize('update', $recurringTransfer);
        
        $recurringTransfer->update(['status' => 'paused']);
        
        return back()->with('success', 'Recurring transfer paused successfully!');
    }

    public function resume(RecurringTransfer $recurringTransfer)
    {
        $this->authorize('update', $recurringTransfer);
        
        $recurringTransfer->update(['status' => 'active']);
        
        return back()->with('success', 'Recurring transfer resumed successfully!');
    }

    public function cancel(RecurringTransfer $recurringTransfer)
    {
        $this->authorize('delete', $recurringTransfer);
        
        $recurringTransfer->update(['status' => 'cancelled']);
        
        return redirect()->route('recurring-transfers.index')
            ->with('success', 'Recurring transfer cancelled successfully!');
    }

    public function destroy(RecurringTransfer $recurringTransfer)
    {
        $this->authorize('delete', $recurringTransfer);
        
        $recurringTransfer->delete();
        
        return redirect()->route('recurring-transfers.index')
            ->with('success', 'Recurring transfer deleted successfully!');
    }
}
