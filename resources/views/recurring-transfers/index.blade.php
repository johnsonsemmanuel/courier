@extends('layouts.dashboard')

@section('title', 'Recurring Transfers - Courier Savings Bank')

@section('content')
<!-- Header -->
<div class="flex justify-between items-start mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Recurring Transfers</h1>
        <p class="text-gray-600 mt-1 text-xs">Manage your scheduled automatic transfers</p>
    </div>
    <a href="{{ route('recurring-transfers.create') }}" class="bg-primary hover:bg-primary-dark text-white font-semibold px-4 py-2 rounded-lg transition text-xs shadow-lg flex items-center space-x-1.5">
        <x-icons name="clock" class="w-4 h-4" />
        <span>New Recurring Transfer</span>
    </a>
</div>

@if($recurringTransfers->count() > 0)
    <div class="space-y-4">
        @foreach($recurringTransfers as $transfer)
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <h3 class="font-bold text-gray-900 text-sm">{{ $transfer->recipient_name }}</h3>
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold
                                {{ $transfer->status === 'active' ? 'bg-green-100 text-green-700' : 
                                   ($transfer->status === 'paused' ? 'bg-yellow-100 text-yellow-700' : 
                                   ($transfer->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700')) }}">
                                {{ ucfirst($transfer->status) }}
                            </span>
                        </div>
                        
                        <div class="grid md:grid-cols-4 gap-3 text-xs text-gray-600 mb-3">
                            <div>
                                <p class="text-gray-500 mb-0.5">Amount</p>
                                <p class="font-bold text-gray-900">${{ number_format($transfer->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 mb-0.5">Frequency</p>
                                <p class="font-semibold capitalize">{{ $transfer->frequency }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 mb-0.5">Next Transfer</p>
                                <p class="font-semibold">{{ $transfer->next_execution_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500 mb-0.5">Executions</p>
                                <p class="font-semibold">{{ $transfer->execution_count }}{{ $transfer->max_executions ? '/' . $transfer->max_executions : '' }}</p>
                            </div>
                        </div>
                        
                        @if($transfer->description)
                            <p class="text-xs text-gray-600 mb-2">{{ $transfer->description }}</p>
                        @endif
                        
                        <p class="text-xs text-gray-500">
                            Account: {{ $transfer->recipient_account }}
                            @if($transfer->end_date)
                                • Ends: {{ $transfer->end_date->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                    
                    <div class="flex space-x-1 ml-4">
                        @if($transfer->status === 'active')
                            <form action="{{ route('recurring-transfers.pause', $transfer) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-yellow-600 hover:text-yellow-700 transition p-2" title="Pause">
                                    <x-icons name="clock" class="w-4 h-4" />
                                </button>
                            </form>
                        @elseif($transfer->status === 'paused')
                            <form action="{{ route('recurring-transfers.resume', $transfer) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-700 transition p-2" title="Resume">
                                    <x-icons name="check" class="w-4 h-4" />
                                </button>
                            </form>
                        @endif
                        
                        @if(in_array($transfer->status, ['active', 'paused']))
                            <form action="{{ route('recurring-transfers.cancel', $transfer) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this recurring transfer?');">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-700 transition p-2" title="Cancel">
                                    <x-icons name="x" class="w-4 h-4" />
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-xl p-10 shadow-sm border border-gray-100 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <x-icons name="clock" class="w-8 h-8 text-gray-400" />
        </div>
        <h3 class="text-base font-bold text-gray-900 mb-2">No Recurring Transfers</h3>
        <p class="text-xs text-gray-600 mb-5">Set up automatic transfers to save time</p>
        <a href="{{ route('recurring-transfers.create') }}" class="inline-flex items-center space-x-1.5 bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-lg transition text-xs">
            <x-icons name="clock" class="w-4 h-4" />
            <span>Create Recurring Transfer</span>
        </a>
    </div>
@endif

<!-- Info Box -->
<div class="bg-purple-50 border border-purple-200 rounded-xl p-4 mt-5">
    <div class="flex items-start">
        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
            <x-icons name="info" class="w-4 h-4 text-primary" />
        </div>
        <div>
            <h4 class="font-bold text-gray-900 mb-1 text-xs">About Recurring Transfers</h4>
            <ul class="text-xs text-gray-700 space-y-1">
                <li>• Transfers execute automatically on schedule</li>
                <li>• You can pause or cancel anytime</li>
                <li>• Ensure sufficient balance before execution date</li>
                <li>• Set end date or maximum executions for control</li>
            </ul>
        </div>
    </div>
</div>
@endsection
