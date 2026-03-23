@extends('layouts.dashboard')

@section('title', 'Create Virtual Card - Courier Savings Bank')

@section('content')
<div>
    <!-- Header with Icon -->
    <div class="mb-5">
        <a href="{{ route('cards.index') }}" class="inline-flex items-center gap-2 text-xs text-gray-600 hover:text-gray-900 mb-3">
            <x-icons name="arrow-left" class="w-4 h-4" />
            Back to Cards
        </a>
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <x-icons name="credit-card" class="w-6 h-6 text-white" />
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Virtual Card</h1>
                <p class="text-xs text-gray-600 mt-1">Set up a new virtual card for secure online payments</p>
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
                <p class="text-xs opacity-90 mb-1">Linked Account Balance</p>
                <p class="text-2xl font-bold">${{ number_format($account->balance, 2) }}</p>
                <p class="text-xs opacity-80 mt-2">Account: {{ $account->account_number }}</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('cards.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Card Holder Name *</label>
                        <input type="text" name="card_holder_name" value="{{ old('card_holder_name', strtoupper(auth()->user()->name)) }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent uppercase"
                               placeholder="JOHN DOE">
                        @error('card_holder_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Card Brand *</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 transition">
                                <input type="radio" name="card_brand" value="visa" checked class="mr-3">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Visa</p>
                                    <p class="text-xs text-gray-500">Widely accepted</p>
                                </div>
                            </label>
                            <label class="relative flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-500 transition">
                                <input type="radio" name="card_brand" value="mastercard" class="mr-3">
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Mastercard</p>
                                    <p class="text-xs text-gray-500">Global network</p>
                                </div>
                            </label>
                        </div>
                        @error('card_brand')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Daily Spending Limit *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-xs text-gray-500">$</span>
                            <input type="number" name="daily_limit" value="{{ old('daily_limit', 1000) }}" min="100" max="10000" step="100" required
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Maximum: $10,000 per day</p>
                        @error('daily_limit')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-medium text-gray-700 mb-2">Monthly Spending Limit *</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2 text-xs text-gray-500">$</span>
                            <input type="number" name="monthly_limit" value="{{ old('monthly_limit', 10000) }}" min="1000" max="100000" step="1000" required
                                   class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Maximum: $100,000 per month</p>
                        @error('monthly_limit')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex gap-3">
                            <i data-lucide="info" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                            <div class="text-xs text-blue-800">
                                <p class="font-semibold mb-1">Virtual Card Benefits:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Instant creation and activation</li>
                                    <li>Secure online payments</li>
                                    <li>Freeze/unfreeze anytime</li>
                                    <li>Customizable spending limits</li>
                                    <li>Valid for 3 years</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-semibold">
                        Create Virtual Card
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
