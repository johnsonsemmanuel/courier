@extends('layouts.dashboard')

@section('title', 'Account Statements - Courier Savings Bank')

@section('content')
<!-- Header -->
<div class="flex justify-between items-start mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Account Statements</h1>
        <p class="text-gray-600 mt-1 text-xs">Download your account statements</p>
    </div>
    <div class="text-right">
        <p class="text-xs text-gray-500">{{ now()->format('l') }}</p>
        <p class="text-xs font-semibold text-gray-900">{{ now()->format('F d, Y') }}</p>
    </div>
</div>

<!-- Quick Download Options -->
<div class="grid md:grid-cols-3 gap-4 mb-5">
    <form action="{{ route('statements.download') }}" method="POST" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
        @csrf
        <input type="hidden" name="start_date" value="{{ now()->subMonth()->format('Y-m-d') }}">
        <input type="hidden" name="end_date" value="{{ now()->format('Y-m-d') }}">
        
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <x-icons name="file-text" class="w-5 h-5 text-primary" />
            </div>
        </div>
        <h3 class="text-sm font-bold text-gray-900 mb-1">Last 30 Days</h3>
        <p class="text-xs text-gray-600 mb-4">{{ now()->subMonth()->format('M d') }} - {{ now()->format('M d, Y') }}</p>
        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-lg transition text-xs">
            Download PDF
        </button>
    </form>

    <form action="{{ route('statements.download') }}" method="POST" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
        @csrf
        <input type="hidden" name="start_date" value="{{ now()->subMonths(3)->format('Y-m-d') }}">
        <input type="hidden" name="end_date" value="{{ now()->format('Y-m-d') }}">
        
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <x-icons name="file-text" class="w-5 h-5 text-blue-600" />
            </div>
        </div>
        <h3 class="text-sm font-bold text-gray-900 mb-1">Last 3 Months</h3>
        <p class="text-xs text-gray-600 mb-4">{{ now()->subMonths(3)->format('M d') }} - {{ now()->format('M d, Y') }}</p>
        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-lg transition text-xs">
            Download PDF
        </button>
    </form>

    <form action="{{ route('statements.download') }}" method="POST" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
        @csrf
        <input type="hidden" name="start_date" value="{{ now()->startOfYear()->format('Y-m-d') }}">
        <input type="hidden" name="end_date" value="{{ now()->format('Y-m-d') }}">
        
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <x-icons name="file-text" class="w-5 h-5 text-green-600" />
            </div>
        </div>
        <h3 class="text-sm font-bold text-gray-900 mb-1">Year to Date</h3>
        <p class="text-xs text-gray-600 mb-4">{{ now()->startOfYear()->format('M d') }} - {{ now()->format('M d, Y') }}</p>
        <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-lg transition text-xs">
            Download PDF
        </button>
    </form>
</div>

<!-- Custom Date Range -->
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
    <h3 class="text-base font-bold text-gray-900 mb-4">Custom Date Range</h3>
    
    <form action="{{ route('statements.download') }}" method="POST" class="space-y-4">
        @csrf
        
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" required
                    class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                    value="{{ now()->subMonth()->format('Y-m-d') }}">
                @error('start_date')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">End Date</label>
                <input type="date" name="end_date" required
                    class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                    value="{{ now()->format('Y-m-d') }}">
                @error('end_date')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-6 rounded-lg transition text-xs shadow-lg flex items-center space-x-2">
                <x-icons name="download" class="w-4 h-4" />
                <span>Generate Statement</span>
            </button>
            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition text-xs">
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Info Box -->
<div class="bg-purple-50 border border-purple-200 rounded-xl p-4 mt-5">
    <div class="flex items-start">
        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
            <x-icons name="info" class="w-4 h-4 text-primary" />
        </div>
        <div>
            <h4 class="font-bold text-gray-900 mb-1 text-xs">About Account Statements</h4>
            <ul class="text-xs text-gray-700 space-y-1">
                <li>• Statements include all transactions within the selected date range</li>
                <li>• PDF format is suitable for printing and record keeping</li>
                <li>• Statements show deposits, withdrawals, and transfers</li>
                <li>• Keep statements for tax and accounting purposes</li>
            </ul>
        </div>
    </div>
</div>
@endsection
