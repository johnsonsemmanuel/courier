@extends('layouts.dashboard')

@section('title', 'Pay Bill - Courier Savings Bank')

@section('content')
<div>
    <!-- Header with Icon -->
    <div class="mb-5">
        <a href="{{ route('bills.index') }}" class="inline-flex items-center gap-2 text-xs text-gray-600 hover:text-gray-900 mb-3">
            <x-icons name="arrow-left" class="w-4 h-4" />
            Back to Bill Payments
        </a>
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <x-icons name="receipt" class="w-6 h-6 text-white" />
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pay Bill</h1>
                <p class="text-xs text-gray-600 mt-1">{{ now()->format('l, F j, Y - g:i A') }}</p>
            </div>
        </div>
    </div>

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-xs">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Account Balance -->
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl p-5 mb-6 text-white">
                <p class="text-xs opacity-90 mb-1">Available Balance</p>
                <p class="text-2xl font-bold">${{ number_format($account->balance, 2) }}</p>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('bills.store') }}" method="POST" id="paymentForm">
                    @csrf

                    <!-- Select Saved Payee -->
                    @if($payees->count() > 0)
                        <div class="mb-6">
                            <label class="block text-xs font-medium text-gray-700 mb-2">Select Saved Payee (Optional)</label>
                            <select id="savedPayee" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">-- Select a saved payee --</option>
                                @foreach($payees as $payee)
                                    <option value="{{ $payee->id }}" 
                                            data-name="{{ $payee->payee_name }}"
                                            data-type="{{ $payee->payee_type }}"
                                            data-account="{{ $payee->account_number }}"
                                            data-provider="{{ $payee->provider }}">
                                        {{ $payee->nickname ?? $payee->payee_name }} - {{ $payee->provider }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <input type="hidden" name="bill_payee_id" id="bill_payee_id">

                    <!-- Payee Name -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Payee Name *</label>
                        <input type="text" name="payee_name" id="payee_name" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Enter payee name">
                        @error('payee_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bill Type -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Bill Type *</label>
                        <select name="payee_type" id="payee_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select bill type</option>
                            <option value="utility">Utility (Electricity, Water, Gas)</option>
                            <option value="telecom">Telecom (Phone, Internet)</option>
                            <option value="subscription">Subscription (Netflix, Spotify)</option>
                            <option value="insurance">Insurance</option>
                            <option value="education">Education</option>
                            <option value="other">Other</option>
                        </select>
                        @error('payee_type')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Provider -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Provider/Company *</label>
                        <input type="text" name="provider" id="provider" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="e.g., Electric Company, MTN, Netflix">
                        @error('provider')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Number -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Account/Reference Number *</label>
                        <input type="text" name="account_number" id="account_number" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="Enter account or reference number">
                        @error('account_number')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Amount *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-xs text-gray-500">$</span>
                            <input type="number" name="amount" step="0.01" min="1" required
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="0.00">
                        </div>
                        @error('amount')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea name="notes" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Add any notes about this payment"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-semibold">
                        Pay Bill
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Auto-fill form when saved payee is selected
        document.getElementById('savedPayee')?.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (this.value) {
                document.getElementById('bill_payee_id').value = this.value;
                document.getElementById('payee_name').value = selected.dataset.name;
                document.getElementById('payee_type').value = selected.dataset.type;
                document.getElementById('account_number').value = selected.dataset.account;
                document.getElementById('provider').value = selected.dataset.provider;
            } else {
                document.getElementById('bill_payee_id').value = '';
                document.getElementById('payee_name').value = '';
                document.getElementById('payee_type').value = '';
                document.getElementById('account_number').value = '';
                document.getElementById('provider').value = '';
            }
        });
    </script>
@endsection
