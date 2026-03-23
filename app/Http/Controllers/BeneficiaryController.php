<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Account;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public function index()
    {
        $beneficiaries = auth()->user()->beneficiaries()->latest()->get();
        return view('beneficiaries.index', compact('beneficiaries'));
    }

    public function create()
    {
        return view('beneficiaries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Verify account exists if it's internal
        if ($request->bank_name === 'Courier Savings Bank') {
            $account = Account::where('account_number', $request->account_number)->first();
            if (!$account) {
                return back()->withErrors(['account_number' => 'Account number not found.'])->withInput();
            }
            
            // Prevent adding self as beneficiary
            if ($account->user_id === auth()->id()) {
                return back()->withErrors(['account_number' => 'You cannot add yourself as a beneficiary.'])->withInput();
            }
        }

        auth()->user()->beneficiaries()->create($request->all());

        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary added successfully!');
    }

    public function edit(Beneficiary $beneficiary)
    {
        $this->authorize('update', $beneficiary);
        return view('beneficiaries.edit', compact('beneficiary'));
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $this->authorize('update', $beneficiary);

        $request->validate([
            'name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $beneficiary->update($request->only(['name', 'nickname', 'email', 'phone']));

        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary updated successfully!');
    }

    public function destroy(Beneficiary $beneficiary)
    {
        $this->authorize('delete', $beneficiary);
        
        $beneficiary->delete();

        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary deleted successfully!');
    }
}
