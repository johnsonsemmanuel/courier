@extends('layouts.dashboard')

@section('title', 'Send Money - Courier Savings Bank')

@section('content')
<div class="mb-5 flex justify-between items-start">
    <div>
        <div class="inline-block bg-purple-100 text-primary px-3 py-1 rounded-full text-xs font-bold mb-2">
            SEND MONEY
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Send Money</h1>
        <p class="text-gray-600 mt-1 text-xs">Transfer funds to another account</p>
    </div>
    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-primary hover:text-primary-dark font-semibold transition text-xs px-4 py-2 bg-purple-50 rounded-lg">
        <x-icons name="arrow-left" class="w-3.5 h-3.5 mr-1.5" />
        Back
    </a>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form action="{{ route('send-money') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2 text-xs">Recipient Account Number</label>
                <input type="text" name="recipient_account" required
                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                    placeholder="Enter account number" value="{{ old('recipient_account') }}">
                @error('recipient_account')
                    <p class="text-red-600 text-xs mt-2 flex items-center">
                        <x-icons name="x" class="w-3 h-3 mr-1" />
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2 text-xs">Recipient Name</label>
                <input type="text" name="recipient_name" required
                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                    placeholder="Enter recipient name" value="{{ old('recipient_name') }}">
                @error('recipient_name')
                    <p class="text-red-600 text-xs mt-2 flex items-center">
                        <x-icons name="x" class="w-3 h-3 mr-1" />
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2 text-xs">Amount</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm font-bold">$</span>
                    <input type="number" name="amount" step="0.01" min="1" max="50000" required
                        class="w-full pl-9 pr-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-sm font-semibold"
                        placeholder="0.00" value="{{ old('amount') }}">
                </div>
                @error('amount')
                    <p class="text-red-600 text-xs mt-2 flex items-center">
                        <x-icons name="x" class="w-3 h-3 mr-1" />
                        {{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-600 mt-2 flex items-center">
                    <x-icons name="info" class="w-3 h-3 mr-1" />
                    Maximum transfer amount: $50,000
                </p>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2 text-xs">Description (Optional)</label>
                <textarea name="description" rows="2"
                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none text-xs"
                    placeholder="What's this payment for?">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-xs mt-2 flex items-center">
                        <x-icons name="x" class="w-3 h-3 mr-1" />
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-5">
                <div class="flex items-start">
                    <div class="w-7 h-7 bg-yellow-100 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                        <x-icons name="alert-triangle" class="w-3.5 h-3.5 text-yellow-600" />
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1 text-xs">Important Notice</h4>
                        <ul class="text-xs text-gray-700 space-y-0.5">
                            <li>• Please verify the recipient account number is correct</li>
                            <li>• Transactions cannot be reversed once completed</li>
                            <li>• Ensure you have sufficient balance in your account</li>
                            <li>• Transfers are processed instantly</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex space-x-2.5">
                <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-2.5 px-5 rounded-xl transition shadow-lg flex items-center justify-center space-x-1.5 text-xs">
                    <x-icons name="dollar-sign" class="w-3.5 h-3.5" />
                    <span>Send Money</span>
                </button>
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition text-xs">
                    Cancel
                </a>
            </div>
        </form>
    </div>
    </div>
@endsection
