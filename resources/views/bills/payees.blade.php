@extends('layouts.dashboard')

@section('title', 'Manage Payees - Courier Savings Bank')

@section('content')
<div>
    <!-- Header with Icon -->
    <div class="flex justify-between items-center mb-5">
        <div>
            <a href="{{ route('bills.index') }}" class="inline-flex items-center gap-2 text-xs text-gray-600 hover:text-gray-900 mb-2">
                <x-icons name="arrow-left" class="w-4 h-4" />
                Back to Bill Payments
            </a>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <x-icons name="users" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Manage Payees</h1>
                    <p class="text-xs text-gray-600 mt-1">{{ now()->format('l, F j, Y - g:i A') }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('bills.create-payee') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-medium flex items-center gap-2">
            <x-icons name="plus" class="w-4 h-4" />
            Add Payee
        </a>
    </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-xs">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Payees Grid -->
            @if($payees->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($payees as $payee)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($payee->payee_name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900">{{ $payee->nickname ?? $payee->payee_name }}</h3>
                                        @if($payee->nickname)
                                            <p class="text-xs text-gray-500">{{ $payee->payee_name }}</p>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('bills.toggle-favorite', $payee) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-yellow-500">
                                        <i data-lucide="star" class="w-4 h-4 {{ $payee->is_favorite ? 'fill-yellow-500 text-yellow-500' : '' }}"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-xs">
                                    <i data-lucide="tag" class="w-3 h-3 text-gray-400"></i>
                                    <span class="text-gray-600">{{ ucfirst($payee->payee_type) }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs">
                                    <i data-lucide="building" class="w-3 h-3 text-gray-400"></i>
                                    <span class="text-gray-600">{{ $payee->provider }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs">
                                    <i data-lucide="hash" class="w-3 h-3 text-gray-400"></i>
                                    <span class="text-gray-600 font-mono">{{ $payee->account_number }}</span>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('bills.edit-payee', $payee) }}" class="flex-1 px-3 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-xs font-medium text-center">
                                    Edit
                                </a>
                                <form action="{{ route('bills.destroy-payee', $payee) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this payee?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 text-xs font-medium">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <i data-lucide="users" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                    <h3 class="text-sm font-medium text-gray-900 mb-2">No saved payees yet</h3>
                    <p class="text-xs text-gray-500 mb-4">Save your frequently used payees for quick bill payments</p>
                    <a href="{{ route('bills.create-payee') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-medium">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Add Your First Payee
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
