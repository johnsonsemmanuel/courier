@extends('layouts.dashboard')

@section('title', 'Virtual Cards - Courier Savings Bank')

@section('content')
<div>
    <!-- Header with Icon -->
    <div class="flex justify-between items-center mb-5">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                <x-icons name="credit-card" class="w-6 h-6 text-white" />
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Virtual Cards</h1>
                <p class="text-xs text-gray-600 mt-1">{{ now()->format('l, F j, Y - g:i A') }}</p>
            </div>
        </div>
        @if($cards->count() < 5)
            <a href="{{ route('cards.create') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-medium flex items-center gap-2">
                <x-icons name="plus" class="w-4 h-4" />
                Create Card
            </a>
        @endif
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

            <!-- Cards Grid -->
            @if($cards->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($cards as $card)
                        <div class="relative">
                            <!-- Card Design -->
                            <div class="relative h-52 rounded-2xl p-6 text-white shadow-xl overflow-hidden {{ $card->card_brand === 'visa' ? 'bg-gradient-to-br from-blue-600 to-blue-800' : 'bg-gradient-to-br from-orange-500 to-red-600' }}">
                                <!-- Background Pattern -->
                                <div class="absolute inset-0 opacity-10">
                                    <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -mr-32 -mt-32"></div>
                                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full -ml-24 -mb-24"></div>
                                </div>

                                <!-- Card Content -->
                                <div class="relative h-full flex flex-col justify-between">
                                    <!-- Top Section -->
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-xs opacity-80 mb-1">{{ ucfirst($card->card_type) }} Card</p>
                                            <p class="text-lg font-bold">{{ strtoupper($card->card_brand) }}</p>
                                        </div>
                                        <div class="text-right">
                                            @if($card->status === 'active')
                                                <span class="px-2 py-1 bg-green-500 bg-opacity-30 text-white rounded text-xs font-medium">Active</span>
                                            @elseif($card->status === 'frozen')
                                                <span class="px-2 py-1 bg-blue-500 bg-opacity-30 text-white rounded text-xs font-medium">Frozen</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-500 bg-opacity-30 text-white rounded text-xs font-medium">Cancelled</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Card Number -->
                                    <div>
                                        <p class="text-lg font-mono tracking-wider">{{ $card->masked_card_number }}</p>
                                    </div>

                                    <!-- Bottom Section -->
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <p class="text-xs opacity-70 mb-1">Card Holder</p>
                                            <p class="text-sm font-semibold">{{ $card->card_holder_name }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs opacity-70 mb-1">Expires</p>
                                            <p class="text-sm font-semibold">{{ $card->expiry_month }}/{{ substr($card->expiry_year, -2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Actions -->
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('cards.show', $card) }}" class="flex-1 px-3 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-xs font-medium text-center">
                                    View Details
                                </a>
                                @if($card->status === 'active')
                                    <form action="{{ route('cards.freeze', $card) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 text-xs font-medium">
                                            Freeze
                                        </button>
                                    </form>
                                @elseif($card->status === 'frozen')
                                    <form action="{{ route('cards.unfreeze', $card) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-3 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 text-xs font-medium">
                                            Unfreeze
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($cards->count() >= 5)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-xs text-yellow-800">
                        <i data-lucide="alert-circle" class="w-4 h-4 inline mr-2"></i>
                        You have reached the maximum limit of 5 virtual cards.
                    </div>
                @endif
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <i data-lucide="credit-card" class="w-12 h-12 text-gray-300 mx-auto mb-4"></i>
                    <h3 class="text-sm font-medium text-gray-900 mb-2">No virtual cards yet</h3>
                    <p class="text-xs text-gray-500 mb-4">Create your first virtual card for secure online payments</p>
                    <a href="{{ route('cards.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-medium">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                        Create Your First Card
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
@endsection
