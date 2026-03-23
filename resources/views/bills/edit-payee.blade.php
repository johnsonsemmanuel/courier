@extends('layouts.dashboard')

@section('title', 'Edit Payee - Courier Savings Bank')

@section('content')
<div>
            <!-- Header -->
            <div class="mb-5">
                <a href="{{ route('bills.payees') }}" class="inline-flex items-center gap-2 text-xs text-gray-600 hover:text-gray-900 mb-3">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to Payees
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Edit Payee</h1>
                <p class="text-xs text-gray-600 mt-1">Update payee details</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('bills.update-payee', $payee) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Payee Name *</label>
                        <input type="text" name="payee_name" value="{{ old('payee_name', $payee->payee_name) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('payee_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Nickname (Optional)</label>
                        <input type="text" name="nickname" value="{{ old('nickname', $payee->nickname) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('nickname')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Bill Type *</label>
                        <select name="payee_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select bill type</option>
                            <option value="utility" {{ old('payee_type', $payee->payee_type) === 'utility' ? 'selected' : '' }}>Utility (Electricity, Water, Gas)</option>
                            <option value="telecom" {{ old('payee_type', $payee->payee_type) === 'telecom' ? 'selected' : '' }}>Telecom (Phone, Internet)</option>
                            <option value="subscription" {{ old('payee_type', $payee->payee_type) === 'subscription' ? 'selected' : '' }}>Subscription (Netflix, Spotify)</option>
                            <option value="insurance" {{ old('payee_type', $payee->payee_type) === 'insurance' ? 'selected' : '' }}>Insurance</option>
                            <option value="education" {{ old('payee_type', $payee->payee_type) === 'education' ? 'selected' : '' }}>Education</option>
                            <option value="other" {{ old('payee_type', $payee->payee_type) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payee_type')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Provider/Company *</label>
                        <input type="text" name="provider" value="{{ old('provider', $payee->provider) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('provider')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Account/Reference Number *</label>
                        <input type="text" name="account_number" value="{{ old('account_number', $payee->account_number) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        @error('account_number')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-semibold">
                        Update Payee
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
