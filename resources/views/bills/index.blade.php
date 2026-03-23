@extends('layouts.dashboard')

@section('title', 'Bill Payments - Courier Savings Bank')

@section('content')
<div>
    <!-- Header with Icon -->
    <div class="flex justify-between items-center mb-5">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <x-icons name="receipt" class="w-6 h-6 text-white" />
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Bill Payments</h1>
                <p class="text-xs text-gray-600 mt-1">{{ now()->format('l, F j, Y - g:i A') }}</p>
            </div>
        </div>
                <div class="flex gap-3">
                    <a href="{{ route('bills.payees') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-xs font-medium flex items-center gap-2">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        Manage Payees
                    </a>
                    <a href="{{ route('bills.create') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-medium flex items-center gap-2">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Pay Bill
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-xs">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Payments List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-5 border-b border-gray-200">
                    <h2 class="text-sm font-semibold text-gray-900">Payment History</h2>
                </div>

                @if($payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500">Date</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500">Payee</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500">Type</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500">Provider</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500">Account #</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500">Amount</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500">Reference</th>
                                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($payments as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 text-xs text-gray-900">
                                            {{ $payment->paid_at ? $payment->paid_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-5 py-4 text-xs font-medium text-gray-900">
                                            {{ $payment->payee_name }}
                                        </td>
                                        <td class="px-5 py-4 text-xs text-gray-600">
                                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-md">
                                                {{ ucfirst($payment->payee_type) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-xs text-gray-600">
                                            {{ $payment->provider }}
                                        </td>
                                        <td class="px-5 py-4 text-xs text-gray-600 font-mono">
                                            {{ $payment->account_number }}
                                        </td>
                                        <td class="px-5 py-4 text-xs font-semibold text-gray-900">
                                            ${{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="px-5 py-4 text-xs text-gray-600 font-mono">
                                            {{ $payment->reference_number }}
                                        </td>
                                        <td class="px-5 py-4 text-xs">
                                            @if($payment->status === 'completed')
                                                <span class="px-2 py-1 bg-green-50 text-green-700 rounded-md font-medium">Completed</span>
                                            @elseif($payment->status === 'pending')
                                                <span class="px-2 py-1 bg-yellow-50 text-yellow-700 rounded-md font-medium">Pending</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-50 text-red-700 rounded-md font-medium">Failed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-5 border-t border-gray-200">
                        {{ $payments->links() }}
                    </div>
                @else
                    <div class="p-12 text-center">
                        <i data-lucide="receipt" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">No bill payments yet</h3>
                        <p class="text-xs text-gray-500 mb-4">Start paying your bills easily and securely</p>
                        <a href="{{ route('bills.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-medium">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Pay Your First Bill
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
