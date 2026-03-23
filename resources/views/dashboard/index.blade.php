@extends('layouts.dashboard')

@section('title', 'Dashboard - Courier Savings Bank')

@section('content')
<!-- Alert Banners -->
@if($taxAlert && $taxAlert->has_tax_obligation)
<div class="mb-5 bg-red-50 border-2 border-red-200 rounded-xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
        <x-icons name="shield-alert" class="w-5 h-5 text-red-600" />
    </div>
    <div class="flex-1">
        <h3 class="text-sm font-bold text-red-900 mb-1">IRS Tax Obligation Alert</h3>
        <p class="text-xs text-red-800 mb-2">You have pending tax obligations with the IRS. All transactions are currently blocked until this is resolved.</p>
        <p class="text-xs text-red-700 font-semibold">Amount Owed: ${{ number_format($taxAlert->tax_amount, 2) }}</p>
        @if($taxAlert->notes)
        <p class="text-xs text-red-600 mt-1">{{ $taxAlert->notes }}</p>
        @endif
    </div>
    <a href="mailto:support@couriersavingsbank.com" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition flex items-center gap-2 flex-shrink-0">
        <x-icons name="alert-circle" class="w-3.5 h-3.5" />
        Contact Support
    </a>
</div>
@endif

@if($account->status === 'frozen')
<div class="mb-5 bg-orange-50 border-2 border-orange-200 rounded-xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
        <x-icons name="snowflake" class="w-5 h-5 text-orange-600" />
    </div>
    <div class="flex-1">
        <h3 class="text-sm font-bold text-orange-900 mb-1">Account Frozen</h3>
        <p class="text-xs text-orange-800">Your account has been temporarily frozen. All transactions are currently disabled.</p>
    </div>
    <a href="mailto:support@couriersavingsbank.com" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-xs font-semibold transition flex items-center gap-2 flex-shrink-0">
        Contact Support
    </a>
</div>
@endif

@if($account->withheld_amount > 0)
<div class="mb-5 bg-yellow-50 border-2 border-yellow-200 rounded-xl p-5 flex items-start gap-4">
    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
        <x-icons name="alert-triangle" class="w-5 h-5 text-yellow-600" />
    </div>
    <div class="flex-1">
        <h3 class="text-sm font-bold text-yellow-900 mb-1">Funds Withheld</h3>
        <p class="text-xs text-yellow-800">A portion of your funds (${{ number_format($account->withheld_amount, 2) }}) is currently withheld and unavailable for transactions.</p>
    </div>
</div>
@endif

<!-- Header -->
<div class="flex justify-between items-start mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ $user->name }}</h1>
        <p class="text-gray-600 mt-1 text-xs">Here's your account overview</p>
    </div>
    <div class="text-right">
        <p class="text-xs text-gray-500">{{ now()->format('l') }}</p>
        <p class="text-xs font-semibold text-gray-900">{{ now()->format('F d, Y') }}</p>
    </div>
</div>

<!-- Account Overview Section -->
<div class="grid lg:grid-cols-5 gap-5 mb-5">
    <!-- Balance Card -->
    <div class="lg:col-span-3">
        <div class="bg-gradient-to-br from-[#6B2D9E] via-[#7B3FA8] to-[#5A2589] rounded-xl p-5 text-white shadow-lg h-full">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-xs opacity-80 mb-1 font-medium uppercase tracking-wide">Available Balance</p>
                    <h2 class="text-4xl font-bold mb-1">${{ number_format($availableBalance, 2) }}</h2>
                    @if($account->withheld_amount > 0)
                    <p class="text-purple-200 text-xs mb-1">Total Balance: ${{ number_format($account->balance, 2) }}</p>
                    <p class="text-purple-300 text-xs">Withheld: ${{ number_format($account->withheld_amount, 2) }}</p>
                    @endif
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-3 py-1.5 border border-white/30">
                    <p class="text-xs opacity-80 mb-0.5 capitalize">{{ $account->account_type }}</p>
                    <p class="font-bold text-xs flex items-center">
                        @if($account->status === 'active')
                            <x-icons name="check" class="w-3 h-3 mr-1" />
                            Active
                        @elseif($account->status === 'frozen')
                            <x-icons name="snowflake" class="w-3 h-3 mr-1" />
                            Frozen
                        @else
                            <x-icons name="alert-circle" class="w-3 h-3 mr-1" />
                            {{ ucfirst($account->status) }}
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 mb-4 border border-white/20">
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <p class="text-purple-200 mb-0.5">User ID</p>
                        <p class="font-bold">{{ $user->user_id }}</p>
                    </div>
                    <div>
                        <p class="text-purple-200 mb-0.5">Account Number</p>
                        <p class="font-bold">{{ $account->account_number }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-purple-200 mb-0.5">Account Name</p>
                        <p class="font-bold">{{ $account->account_name }}</p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('send-money') }}" class="bg-white text-primary hover:bg-gray-100 px-4 py-2 rounded-lg font-semibold transition shadow-lg flex items-center space-x-1.5 text-xs">
                    <x-icons name="send" class="w-3.5 h-3.5" />
                    <span>Send Money</span>
                </a>
                <a href="{{ route('bills.index') }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg font-semibold transition border border-white/30 flex items-center space-x-1.5 text-xs">
                    <x-icons name="receipt" class="w-3.5 h-3.5" />
                    <span>Pay Bills</span>
                </a>
                <a href="{{ route('deposit') }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg font-semibold transition border border-white/30 flex items-center space-x-1.5 text-xs">
                    <x-icons name="arrow-right" class="w-3.5 h-3.5 transform rotate-180" />
                    <span>Deposit</span>
                </a>
                <a href="{{ route('withdraw') }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg font-semibold transition border border-white/30 flex items-center space-x-1.5 text-xs">
                    <x-icons name="arrow-right" class="w-3.5 h-3.5" />
                    <span>Withdraw</span>
                </a>
                <a href="{{ route('cards.index') }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg font-semibold transition border border-white/30 flex items-center space-x-1.5 text-xs">
                    <x-icons name="credit-card" class="w-3.5 h-3.5" />
                    <span>Cards</span>
                </a>
                <a href="{{ route('beneficiaries.index') }}" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-4 py-2 rounded-lg font-semibold transition border border-white/30 flex items-center space-x-1.5 text-xs">
                    <x-icons name="user-plus" class="w-3.5 h-3.5" />
                    <span>Add Beneficiary</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="lg:col-span-2 grid grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <x-icons name="trending-up" class="w-4 h-4 text-green-600" />
                </div>
            </div>
            <p class="text-xs text-gray-600 mb-1 font-medium uppercase tracking-wide">This Month Income</p>
            <p class="text-xl font-bold text-gray-900">${{ number_format($monthlyIncome, 2) }}</p>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                    <x-icons name="trending-down" class="w-4 h-4 text-red-600" />
                </div>
            </div>
            <p class="text-xs text-gray-600 mb-1 font-medium uppercase tracking-wide">This Month Expenses</p>
            <p class="text-xl font-bold text-gray-900">${{ number_format($monthlyExpenses, 2) }}</p>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <x-icons name="file-text" class="w-4 h-4 text-blue-600" />
                </div>
            </div>
            <p class="text-xs text-gray-600 mb-1 font-medium uppercase tracking-wide">Transactions</p>
            <p class="text-xl font-bold text-gray-900">{{ $monthlyTransactionCount }}</p>
        </div>
        
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <x-icons name="clock" class="w-4 h-4 text-primary" />
                </div>
            </div>
            <p class="text-xs text-gray-600 mb-1 font-medium uppercase tracking-wide">Pending</p>
            <p class="text-xl font-bold text-gray-900">{{ $pendingCount }}</p>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="grid lg:grid-cols-3 gap-5">
    <!-- Recent Transactions (Left - 2 columns) -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-base font-bold text-gray-900">Recent Activity</h3>
                <a href="{{ route('transactions.index') }}" class="text-primary font-semibold hover:text-primary-dark transition flex items-center space-x-1 text-xs">
                    <span>View All</span>
                    <x-icons name="arrow-right" class="w-3 h-3" />
                </a>
            </div>
            
            @if($recentTransactions->count() > 0)
                <div class="space-y-2">
                    @foreach($recentTransactions as $transaction)
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-100 last:border-0 hover:bg-gray-50 rounded-lg px-2.5 transition">
                            <div class="flex items-center space-x-2.5">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                    {{ $transaction->transaction_type === 'deposit' ? 'bg-green-100' : ($transaction->transaction_type === 'withdrawal' ? 'bg-orange-100' : 'bg-blue-100') }}">
                                    @if($transaction->transaction_type === 'deposit')
                                        <x-icons name="arrow-right" class="w-4 h-4 text-green-600 transform rotate-180" />
                                    @elseif($transaction->transaction_type === 'withdrawal')
                                        <x-icons name="arrow-right" class="w-4 h-4 text-orange-600" />
                                    @else
                                        <x-icons name="send" class="w-4 h-4 text-blue-600" />
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-xs capitalize">{{ str_replace('_', ' ', $transaction->transaction_type) }}</p>
                                    <p class="text-xs text-gray-600">{{ $transaction->created_at->format('M d, Y • h:i A') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-sm {{ $transaction->transaction_type === 'deposit' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->transaction_type === 'deposit' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                </p>
                                <p class="text-xs text-gray-600 capitalize">{{ $transaction->status }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2.5">
                        <x-icons name="file-text" class="w-7 h-7 text-gray-400" />
                    </div>
                    <p class="text-gray-600 text-xs font-medium mb-1">No transactions yet</p>
                    <p class="text-gray-500 text-xs mb-3">Start by making a deposit or transfer</p>
                    <a href="{{ route('deposit') }}" class="inline-flex items-center space-x-1.5 bg-primary hover:bg-primary-dark text-white font-semibold px-4 py-2 rounded-lg transition text-xs">
                        <span>Make a Deposit</span>
                        <x-icons name="arrow-right" class="w-3 h-3" />
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-5">
        <!-- Quick Transfer -->
        @if($savedBeneficiaries->count() > 0)
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-bold text-gray-900">Quick Transfer</h3>
                <a href="{{ route('beneficiaries.index') }}" class="text-primary text-xs hover:text-primary-dark">View All</a>
            </div>
            <div class="space-y-2">
                @foreach($savedBeneficiaries as $beneficiary)
                <a href="{{ route('send-money', ['beneficiary' => $beneficiary->id]) }}" class="flex items-center justify-between p-2.5 hover:bg-gray-50 rounded-lg transition group">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-gradient-to-br from-[#6B2D9E] to-[#5A2589] rounded-lg flex items-center justify-center text-white font-bold text-xs">
                            {{ strtoupper(substr($beneficiary->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">{{ $beneficiary->name }}</p>
                            <p class="text-xs text-gray-500">{{ substr($beneficiary->account_number, 0, 4) }}****</p>
                        </div>
                    </div>
                    <x-icons name="arrow-right" class="w-3.5 h-3.5 text-gray-400 group-hover:text-primary transition" />
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Upcoming Payments -->
        @if($upcomingTransfers->count() > 0)
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-bold text-gray-900">Upcoming Payments</h3>
                <a href="{{ route('recurring-transfers.index') }}" class="text-primary text-xs hover:text-primary-dark">View All</a>
            </div>
            <div class="space-y-2">
                @foreach($upcomingTransfers as $transfer)
                <div class="flex items-center justify-between p-2.5 border-b border-gray-100 last:border-0">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <x-icons name="repeat" class="w-4 h-4 text-blue-600" />
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">{{ $transfer->recipient_name }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($transfer->next_execution_date)->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <p class="text-xs font-bold text-gray-900">${{ number_format($transfer->amount, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Virtual Cards Overview -->
        @if($activeCardsCount > 0)
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-xl p-5 text-white shadow-lg">
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-sm font-bold">Virtual Cards</h3>
                <a href="{{ route('cards.index') }}" class="text-xs text-gray-300 hover:text-white">Manage</a>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <x-icons name="credit-card" class="w-5 h-5" />
                </div>
                <div>
                    <p class="text-xs text-gray-300">Active Cards</p>
                    <p class="text-xl font-bold">{{ $activeCardsCount }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Download Statement -->
        <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-xl p-5 border border-blue-100">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <x-icons name="download" class="w-5 h-5 text-blue-600" />
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Account Statement</h3>
                    <p class="text-xs text-gray-600 mb-3">Download your monthly statement</p>
                    <a href="{{ route('statements.index') }}" class="inline-flex items-center gap-1.5 bg-primary hover:bg-primary-dark text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                        <x-icons name="download" class="w-3 h-3" />
                        Download
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
