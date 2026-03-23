@extends('layouts.dashboard')

@section('title', 'Transaction History - Courier Savings Bank')

@section('content')
<div class="mb-5">
    <div class="inline-block bg-purple-100 text-primary px-3 py-1 rounded-full text-xs font-bold mb-2">
        TRANSACTION HISTORY
    </div>
    <h1 class="text-2xl font-bold text-gray-900">Transaction History</h1>
    <p class="text-gray-600 mt-1 text-xs">View and filter all your transactions</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-5">
    <form method="GET" action="{{ route('transactions.index') }}" class="grid md:grid-cols-5 gap-3">
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                placeholder="Reference #">
        </div>
        
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Type</label>
            <select name="type" class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs">
                <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
            </select>
        </div>
        
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Status</label>
            <select name="status" class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>
        
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">From Date</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs">
        </div>
        
        <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1.5">To Date</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs">
        </div>
        
        <div class="md:col-span-5 flex space-x-2">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-semibold px-4 py-2 rounded-lg transition flex items-center space-x-1.5 text-xs">
                <x-icons name="search" class="w-3.5 h-3.5" />
                <span>Apply Filters</span>
            </button>
            <a href="{{ route('transactions.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-lg transition flex items-center space-x-1.5 text-xs">
                <x-icons name="x" class="w-3.5 h-3.5" />
                <span>Clear</span>
            </a>
        </div>
    </form>
</div>

<!-- Transactions List -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
    @if($transactions->count() > 0)
        <div class="space-y-2.5">
            @foreach($transactions as $transaction)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0 hover:bg-gray-50 rounded-lg px-3 transition">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center
                            {{ $transaction->transaction_type === 'deposit' ? 'bg-green-100' : ($transaction->transaction_type === 'withdrawal' ? 'bg-orange-100' : 'bg-blue-100') }}">
                            @if($transaction->transaction_type === 'deposit')
                                <x-icons name="arrow-right" class="w-4 h-4 text-green-600 transform rotate-180" />
                            @elseif($transaction->transaction_type === 'withdrawal')
                                <x-icons name="arrow-right" class="w-4 h-4 text-orange-600" />
                            @else
                                <x-icons name="dollar-sign" class="w-4 h-4 text-blue-600" />
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-xs capitalize">{{ str_replace('_', ' ', $transaction->transaction_type) }}</p>
                            <p class="text-xs text-gray-600">{{ $transaction->created_at->format('M d, Y • h:i A') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Ref: {{ $transaction->reference_number }}</p>
                            @if($transaction->description)
                                <p class="text-xs text-gray-600 mt-0.5">{{ $transaction->description }}</p>
                            @endif
                            @if($transaction->recipient_account)
                                <p class="text-xs text-gray-600 mt-0.5">To: {{ $transaction->recipient_name }} ({{ $transaction->recipient_account }})</p>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-sm {{ $transaction->transaction_type === 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $transaction->transaction_type === 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                        </p>
                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold mt-1
                            {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-700' : ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                        <div class="mt-2">
                            <a href="{{ route('transactions.receipt', $transaction->id) }}" class="text-primary hover:text-primary-dark text-xs font-semibold flex items-center justify-end space-x-1">
                                <x-icons name="download" class="w-3 h-3" />
                                <span>Receipt</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $transactions->links() }}
        </div>
    @else
        <div class="text-center py-10">
            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <x-icons name="file-text" class="w-7 h-7 text-gray-400" />
            </div>
            <p class="text-gray-600 text-sm font-medium mb-1">No transactions found</p>
            <p class="text-gray-500 text-xs mb-4">
                @if(request()->hasAny(['search', 'type', 'status', 'date_from', 'date_to']))
                    Try adjusting your filters
                @else
                    Start by making a deposit or transfer
                @endif
            </p>
            <a href="{{ route('deposit') }}" class="inline-flex items-center space-x-1.5 bg-primary hover:bg-primary-dark text-white font-semibold px-4 py-2 rounded-lg transition text-xs">
                <span>Make a Deposit</span>
                <x-icons name="arrow-right" class="w-3 h-3" />
            </a>
        </div>
    @endif
</div>
@endsection
