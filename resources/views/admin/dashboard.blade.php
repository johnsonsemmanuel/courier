@extends('layouts.dashboard')

@section('title', 'Admin Control Panel - Courier Savings Bank')

@section('content')
<!-- Header -->
<div class="flex justify-between items-start mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Admin Control Panel</h1>
        <p class="text-gray-600 mt-1 text-xs">Manage users, transactions, and system settings</p>
    </div>
</div>

<!-- System Stats -->
<div class="grid md:grid-cols-4 gap-4 mb-5">
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <x-icons name="users" class="w-6 h-6 text-white" />
            </div>
            <x-icons name="arrow-right" class="w-5 h-5 text-white/60" />
        </div>
        <p class="text-xs text-purple-100 mb-1 font-medium uppercase tracking-wide">Total Users</p>
        <p class="text-3xl font-bold text-white">{{ $totalUsers }}</p>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <x-icons name="file-text" class="w-6 h-6 text-white" />
            </div>
            <x-icons name="arrow-right" class="w-5 h-5 text-white/60" />
        </div>
        <p class="text-xs text-purple-100 mb-1 font-medium uppercase tracking-wide">Total Transactions</p>
        <p class="text-3xl font-bold text-white">{{ number_format($totalTransactions) }}</p>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <x-icons name="dollar-sign" class="w-6 h-6 text-white" />
            </div>
            <x-icons name="arrow-right" class="w-5 h-5 text-white/60" />
        </div>
        <p class="text-xs text-purple-100 mb-1 font-medium uppercase tracking-wide">System Balance</p>
        <p class="text-3xl font-bold text-white">${{ number_format($totalBalance, 0) }}</p>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg text-white">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <x-icons name="alert-triangle" class="w-6 h-6 text-white" />
            </div>
            <x-icons name="arrow-right" class="w-5 h-5 text-white/60" />
        </div>
        <p class="text-xs text-purple-100 mb-1 font-medium uppercase tracking-wide">Active Tax Alerts</p>
        <p class="text-3xl font-bold text-white">{{ $pendingTaxAlerts }}</p>
    </div>
</div>

<!-- Admin Actions -->
<div class="grid md:grid-cols-3 gap-4 mb-5">
    <!-- User Management -->
    <a href="{{ route('admin.users') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <x-icons name="users" class="w-6 h-6 text-white" />
            </div>
            <x-icons name="arrow-right" class="w-5 h-5 text-white/60 group-hover:text-white transition" />
        </div>
        <h3 class="text-base font-bold text-white mb-1">User Management</h3>
        <p class="text-purple-100 text-xs mb-3">View, edit, and manage all user accounts</p>
        <div class="flex items-center gap-2 text-xs">
            <span class="px-2 py-1 bg-white/20 text-white rounded font-semibold">{{ $totalUsers }} Users</span>
        </div>
    </a>

    <!-- Tax & IRS Controls -->
    <a href="{{ route('admin.users') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <x-icons name="alert-triangle" class="w-6 h-6 text-white" />
            </div>
            <x-icons name="arrow-right" class="w-5 h-5 text-white/60 group-hover:text-white transition" />
        </div>
        <h3 class="text-base font-bold text-white mb-1">Tax & IRS Controls</h3>
        <p class="text-purple-100 text-xs mb-3">Set tax obligations and block transactions</p>
        <div class="flex items-center gap-2 text-xs">
            <span class="px-2 py-1 bg-white/20 text-white rounded font-semibold">{{ $pendingTaxAlerts }} Active</span>
        </div>
    </a>

    <!-- Account Controls -->
    <a href="{{ route('admin.users') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <x-icons name="shield-check" class="w-6 h-6 text-white" />
            </div>
            <x-icons name="arrow-right" class="w-5 h-5 text-white/60 group-hover:text-white transition" />
        </div>
        <h3 class="text-base font-bold text-white mb-1">Account Controls</h3>
        <p class="text-purple-100 text-xs mb-3">Freeze, add funds, withhold balances</p>
        <div class="flex items-center gap-2 text-xs">
            <span class="px-2 py-1 bg-white/20 text-white rounded font-semibold">Full Access</span>
        </div>
    </a>
</div>

<!-- Quick Stats Grid -->
<div class="grid md:grid-cols-2 gap-4 mb-5">
    <!-- Pending Transactions -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Pending Transactions</h3>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <x-icons name="clock" class="w-5 h-5 text-yellow-600" />
            </div>
        </div>
        <div class="space-y-3">
            @php
                $pendingTransactions = $recentTransactions->where('status', 'pending');
            @endphp
            @if($pendingTransactions->count() > 0)
                @foreach($pendingTransactions->take(3) as $transaction)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <div>
                            <p class="text-xs font-bold text-gray-900">{{ $transaction->account->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($transaction->transaction_type) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-gray-900">${{ number_format($transaction->amount, 2) }}</p>
                            <span class="text-xs px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full font-semibold">Pending</span>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-xs text-gray-500 text-center py-4">No pending transactions</p>
            @endif
        </div>
    </div>

    <!-- Users with Tax Alerts -->
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Users with Tax Alerts</h3>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <x-icons name="alert-triangle" class="w-5 h-5 text-red-600" />
            </div>
        </div>
        <div class="space-y-3">
            @php
                $usersWithTax = \App\Models\User::whereHas('taxAlert', function($q) {
                    $q->where('has_tax_obligation', true);
                })->with('accounts')->take(3)->get();
            @endphp
            @if($usersWithTax->count() > 0)
                @foreach($usersWithTax as $user)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100">
                        <div>
                            <p class="text-xs font-bold text-gray-900">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full font-semibold">Blocked</span>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-xs text-gray-500 text-center py-4">No active tax alerts</p>
            @endif
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base font-bold text-gray-900">Recent System Activity</h2>
        <a href="{{ route('admin.users') }}" class="text-xs text-primary hover:text-primary-dark font-semibold">View All →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">User</th>
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Account</th>
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Type</th>
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Amount</th>
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Date</th>
                    <th class="text-center py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentTransactions->take(10) as $transaction)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-3 px-3">
                            <p class="text-xs font-bold text-gray-900">{{ $transaction->account->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $transaction->account->user->email }}</p>
                        </td>
                        <td class="py-3 px-3 text-gray-700 font-mono text-xs">{{ $transaction->account->account_number }}</td>
                        <td class="py-3 px-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                                {{ $transaction->transaction_type === 'deposit' ? 'bg-green-100 text-green-700' : ($transaction->transaction_type === 'withdrawal' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ ucfirst($transaction->transaction_type) }}
                            </span>
                        </td>
                        <td class="py-3 px-3 font-bold text-gray-900 text-xs">${{ number_format($transaction->amount, 2) }}</td>
                        <td class="py-3 px-3 text-gray-600 text-xs">{{ $transaction->created_at->format('M d, h:i A') }}</td>
                        <td class="py-3 px-3 text-center">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                                {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-700' : ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
