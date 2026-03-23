<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CardController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $cards = auth()->user()->cards()->with('account')->latest()->get();
        return view('cards.index', compact('cards'));
    }

    public function create()
    {
        $account = auth()->user()->accounts()->first();
        
        if (!$account) {
            return redirect()->route('cards.index')->with('error', 'No account found. Please contact support.');
        }

        return view('cards.create', compact('account'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'card_holder_name' => 'required|string|max:255',
            'card_brand' => 'required|in:visa,mastercard',
            'daily_limit' => 'required|numeric|min:100|max:10000',
            'monthly_limit' => 'required|numeric|min:1000|max:100000',
        ]);

        $account = auth()->user()->accounts()->first();

        if (!$account) {
            return back()->with('error', 'No account found.');
        }

        // Check if user already has 5 cards (limit)
        if (auth()->user()->cards()->count() >= 5) {
            return back()->with('error', 'You have reached the maximum limit of 5 cards.');
        }

        // Generate card details
        $cardNumber = $this->generateCardNumber($validated['card_brand']);
        $cvv = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        $expiryYear = now()->addYears(3)->format('Y');
        $expiryMonth = now()->format('m');

        Card::create([
            'user_id' => auth()->id(),
            'account_id' => $account->id,
            'card_number' => $cardNumber,
            'card_holder_name' => strtoupper($validated['card_holder_name']),
            'cvv' => $cvv,
            'expiry_month' => $expiryMonth,
            'expiry_year' => $expiryYear,
            'card_type' => 'virtual',
            'card_brand' => $validated['card_brand'],
            'status' => 'active',
            'daily_limit' => $validated['daily_limit'],
            'monthly_limit' => $validated['monthly_limit'],
        ]);

        return redirect()->route('cards.index')->with('success', 'Virtual card created successfully!');
    }

    public function show(Card $card)
    {
        $this->authorize('view', $card);
        return view('cards.show', compact('card'));
    }

    public function freeze(Card $card)
    {
        $this->authorize('update', $card);

        if ($card->status === 'cancelled') {
            return back()->with('error', 'Cannot freeze a cancelled card.');
        }

        $card->update(['status' => 'frozen']);

        return back()->with('success', 'Card frozen successfully!');
    }

    public function unfreeze(Card $card)
    {
        $this->authorize('update', $card);

        if ($card->status === 'cancelled') {
            return back()->with('error', 'Cannot unfreeze a cancelled card.');
        }

        $card->update(['status' => 'active']);

        return back()->with('success', 'Card unfrozen successfully!');
    }

    public function updateLimits(Request $request, Card $card)
    {
        $this->authorize('update', $card);

        $validated = $request->validate([
            'daily_limit' => 'required|numeric|min:100|max:10000',
            'monthly_limit' => 'required|numeric|min:1000|max:100000',
        ]);

        $card->update($validated);

        return back()->with('success', 'Card limits updated successfully!');
    }

    public function cancel(Card $card)
    {
        $this->authorize('delete', $card);

        $card->update(['status' => 'cancelled']);

        return redirect()->route('cards.index')->with('success', 'Card cancelled successfully!');
    }

    private function generateCardNumber(string $brand): string
    {
        // Generate a valid-looking card number
        $prefix = $brand === 'visa' ? '4' : '5';
        $cardNumber = $prefix . str_pad(rand(0, 999999999999999), 15, '0', STR_PAD_LEFT);
        
        return $cardNumber;
    }
}
