@extends('layouts.dashboard')

@section('title', 'Deposit - Courier Savings Bank')

@section('content')
<div class="mb-5 flex justify-between items-start">
    <div>
        <div class="inline-block bg-purple-100 text-primary px-3 py-1 rounded-full text-xs font-bold mb-2">
            DEPOSIT FUNDS
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Deposit Funds</h1>
        <p class="text-gray-600 mt-1 text-xs">Add money to your account securely</p>
    </div>
    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-primary hover:text-primary-dark font-semibold transition text-xs px-4 py-2 bg-purple-50 rounded-lg">
        <x-icons name="arrow-left" class="w-3.5 h-3.5 mr-1.5" />
        Back
    </a>
</div>

<!-- Check for Tax Alert -->
@php
    $taxAlert = Auth::user()->taxAlert;
@endphp

@if($taxAlert && $taxAlert->has_tax_obligation)
<div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-sm">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <x-icons name="shield-alert" class="w-6 h-6 text-red-600" />
        </div>
        <div class="flex-1">
            <h3 class="text-base font-bold text-red-900 mb-2">Deposits Blocked - IRS Tax Obligation</h3>
            <p class="text-sm text-red-800 mb-3">You have pending tax obligations with the IRS. All deposits and transactions are currently blocked until this is resolved.</p>
            <div class="bg-red-100 rounded-lg p-3 mb-3">
                <p class="text-xs text-red-700 font-semibold">Amount Owed: ${{ number_format($taxAlert->tax_amount, 2) }}</p>
                @if($taxAlert->notes)
                <p class="text-xs text-red-600 mt-1">{{ $taxAlert->notes }}</p>
                @endif
            </div>
            <a href="mailto:support@couriersavingsbank.com" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition shadow-lg">
                <x-icons name="send" class="w-4 h-4" />
                Contact Support: support@couriersavingsbank.com
            </a>
        </div>
    </div>
</div>
@else
<!-- Payment Method Selection -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-5">
    <h2 class="text-base font-bold text-gray-900 mb-4">Choose Payment Method</h2>
    
    <div class="grid md:grid-cols-2 gap-4">
        <!-- Stripe Payment -->
        <div onclick="selectPaymentMethod('stripe')" id="method-stripe" class="payment-method cursor-pointer border-2 border-purple-600 bg-purple-50 rounded-xl p-4 hover:shadow-lg transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <x-icons name="credit-card" class="w-5 h-5 text-purple-600" />
                </div>
                <div class="w-5 h-5 bg-purple-600 rounded-full flex items-center justify-center">
                    <x-icons name="check" class="w-3 h-3 text-white" />
                </div>
            </div>
            <h3 class="font-bold text-gray-900 mb-1 text-sm">Credit/Debit Card</h3>
            <p class="text-xs text-gray-600 mb-2">Instant deposit via Stripe</p>
            <div class="flex items-center gap-2 text-xs">
                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-semibold">Instant</span>
                <span class="text-gray-500">2.9% + $0.30 fee</span>
            </div>
        </div>

        <!-- Bank Transfer -->
        <div onclick="selectPaymentMethod('bank')" id="method-bank" class="payment-method cursor-pointer border-2 border-gray-200 bg-white rounded-xl p-4 hover:shadow-lg transition">
            <div class="flex items-start justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <x-icons name="building" class="w-5 h-5 text-blue-600" />
                </div>
                <div class="w-5 h-5 bg-gray-200 rounded-full hidden check-icon"></div>
            </div>
            <h3 class="font-bold text-gray-900 mb-1 text-sm">Bank Transfer</h3>
            <p class="text-xs text-gray-600 mb-2">ACH or Wire Transfer</p>
            <div class="flex items-center gap-2 text-xs">
                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-semibold">1-3 Days</span>
                <span class="text-gray-500">Lower fees</span>
            </div>
        </div>
    </div>
</div>

<!-- Stripe Payment Form -->
<div id="form-stripe" class="payment-form bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
    <h2 class="text-base font-bold text-gray-900 mb-4">Card Payment Details</h2>
    
    <form action="{{ route('deposit.stripe') }}" method="POST" id="stripeForm">
        @csrf
        <input type="hidden" name="payment_method" value="stripe">
        
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-xs">Amount</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm font-bold">$</span>
                <input type="number" name="amount" step="0.01" min="1" required
                    class="w-full pl-9 pr-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-sm font-semibold"
                    placeholder="0.00" value="{{ old('amount') }}">
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-xs">Card Information</label>
            <div class="border-2 border-gray-200 rounded-xl p-4 bg-gray-50">
                <p class="text-xs text-gray-600 mb-2">Stripe integration requires API keys. For demo purposes, this will simulate a successful payment.</p>
                <input type="text" placeholder="4242 4242 4242 4242" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-2 text-xs" disabled>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" placeholder="MM / YY" class="px-3 py-2 border border-gray-300 rounded-lg text-xs" disabled>
                    <input type="text" placeholder="CVC" class="px-3 py-2 border border-gray-300 rounded-lg text-xs" disabled>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-xs">Description (Optional)</label>
            <textarea name="description" rows="2"
                class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none text-xs"
                placeholder="Add a note about this deposit">{{ old('description') }}</textarea>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mb-5">
            <div class="flex items-start">
                <x-icons name="info" class="w-4 h-4 text-blue-600 mr-2 flex-shrink-0 mt-0.5" />
                <div class="text-xs text-blue-800">
                    <p class="font-semibold mb-1">Stripe Payment Processing</p>
                    <p>• Instant deposit to your account</p>
                    <p>• Secure payment processing</p>
                    <p>• Fee: 2.9% + $0.30 per transaction</p>
                </div>
            </div>
        </div>

        <div class="flex space-x-2.5">
            <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-2.5 px-5 rounded-xl transition shadow-lg flex items-center justify-center space-x-1.5 text-xs">
                <x-icons name="credit-card" class="w-3.5 h-3.5" />
                <span>Process Payment</span>
            </button>
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition text-xs">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Bank Transfer Form -->
<div id="form-bank" class="payment-form hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
    <h2 class="text-base font-bold text-gray-900 mb-4">Bank Transfer Instructions</h2>
    
    <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-5 mb-5">
        <h3 class="font-bold text-gray-900 mb-3 text-sm">Our Bank Details</h3>
        <div class="space-y-2 text-xs">
            <div class="flex justify-between py-2 border-b border-blue-200">
                <span class="text-gray-600">Bank Name:</span>
                <span class="font-bold text-gray-900">Courier Savings Bank</span>
            </div>
            <div class="flex justify-between py-2 border-b border-blue-200">
                <span class="text-gray-600">Account Name:</span>
                <span class="font-bold text-gray-900">Courier Savings Bank Ltd</span>
            </div>
            <div class="flex justify-between py-2 border-b border-blue-200">
                <span class="text-gray-600">Account Number:</span>
                <span class="font-bold text-gray-900 font-mono">1234567890</span>
            </div>
            <div class="flex justify-between py-2 border-b border-blue-200">
                <span class="text-gray-600">Routing Number:</span>
                <span class="font-bold text-gray-900 font-mono">021000021</span>
            </div>
            <div class="flex justify-between py-2 border-b border-blue-200">
                <span class="text-gray-600">SWIFT Code:</span>
                <span class="font-bold text-gray-900 font-mono">CSBANK01</span>
            </div>
            <div class="flex justify-between py-2">
                <span class="text-gray-600">Reference:</span>
                <span class="font-bold text-primary font-mono">{{ Auth::user()->user_id }}</span>
            </div>
        </div>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-5">
        <div class="flex items-start">
            <x-icons name="alert-triangle" class="w-4 h-4 text-yellow-600 mr-2 flex-shrink-0 mt-0.5" />
            <div class="text-xs text-yellow-800">
                <p class="font-semibold mb-2">Important Instructions:</p>
                <ol class="list-decimal list-inside space-y-1">
                    <li>Use your User ID ({{ Auth::user()->user_id }}) as the transfer reference</li>
                    <li>Bank transfers typically take 1-3 business days to process</li>
                    <li>Funds will be added to your account after verification</li>
                    <li>Contact support if funds don't appear within 3 business days</li>
                </ol>
            </div>
        </div>
    </div>

    <form action="{{ route('deposit.bank') }}" method="POST">
        @csrf
        <input type="hidden" name="payment_method" value="bank_transfer">
        
        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-xs">Expected Transfer Amount</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm font-bold">$</span>
                <input type="number" name="amount" step="0.01" min="1" required
                    class="w-full pl-9 pr-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-sm font-semibold"
                    placeholder="0.00">
            </div>
            <p class="text-xs text-gray-500 mt-1">Enter the amount you plan to transfer</p>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 font-semibold mb-2 text-xs">Notes (Optional)</label>
            <textarea name="description" rows="2"
                class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none text-xs"
                placeholder="Any additional information"></textarea>
        </div>

        <div class="flex space-x-2.5">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition shadow-lg flex items-center justify-center space-x-1.5 text-xs">
                <x-icons name="check" class="w-3.5 h-3.5" />
                <span>I've Initiated Transfer</span>
            </button>
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition text-xs">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Support Section -->
<div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl p-5 border border-purple-100 mt-5">
    <div class="flex items-start gap-3">
        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
            <x-icons name="alert-circle" class="w-5 h-5 text-purple-600" />
        </div>
        <div class="flex-1">
            <h3 class="text-sm font-bold text-gray-900 mb-1">Need Help?</h3>
            <p class="text-xs text-gray-600 mb-2">Our support team is here to assist you with deposits and account questions.</p>
            <a href="mailto:support@couriersavingsbank.com" class="inline-flex items-center gap-1.5 bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-lg text-xs font-semibold transition">
                <x-icons name="send" class="w-3 h-3" />
                support@couriersavingsbank.com
            </a>
        </div>
    </div>
</div>
@endif

<script>
function selectPaymentMethod(method) {
    // Remove active state from all methods
    document.querySelectorAll('.payment-method').forEach(el => {
        el.classList.remove('border-purple-600', 'bg-purple-50');
        el.classList.add('border-gray-200', 'bg-white');
        el.querySelector('.check-icon').classList.add('hidden');
        el.querySelector('.check-icon').classList.remove('bg-purple-600');
        el.querySelector('.check-icon').classList.add('bg-gray-200');
    });
    
    // Add active state to selected method
    const selectedMethod = document.getElementById('method-' + method);
    selectedMethod.classList.add('border-purple-600', 'bg-purple-50');
    selectedMethod.classList.remove('border-gray-200', 'bg-white');
    const checkIcon = selectedMethod.querySelector('.check-icon');
    checkIcon.classList.remove('hidden', 'bg-gray-200');
    checkIcon.classList.add('bg-purple-600');
    
    // Show corresponding form
    document.querySelectorAll('.payment-form').forEach(form => {
        form.classList.add('hidden');
    });
    document.getElementById('form-' + method).classList.remove('hidden');
}

// Initialize with stripe selected
document.addEventListener('DOMContentLoaded', function() {
    selectPaymentMethod('stripe');
});
</script>
@endsection
