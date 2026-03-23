@extends('layouts.dashboard')

@section('title', 'Card Details - Courier Savings Bank')

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
                <h1 class="text-2xl font-bold text-gray-900">Card Details</h1>
                <p class="text-xs text-gray-600 mt-1">{{ now()->format('l, F j, Y - g:i A') }}</p>
            </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Card Display -->
                <div>
                    <div class="relative h-56 rounded-2xl p-6 text-white shadow-xl overflow-hidden {{ $card->card_brand === 'visa' ? 'bg-gradient-to-br from-blue-600 to-blue-800' : 'bg-gradient-to-br from-orange-500 to-red-600' }}">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full -mr-32 -mt-32"></div>
                            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full -ml-24 -mb-24"></div>
                        </div>

                        <div class="relative h-full flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs opacity-80 mb-1">{{ ucfirst($card->card_type) }} Card</p>
                                    <p class="text-xl font-bold">{{ strtoupper($card->card_brand) }}</p>
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

                            <div>
                                <p class="text-xl font-mono tracking-wider mb-2" id="cardNumber">{{ $card->masked_card_number }}</p>
                                <button onclick="toggleCardNumber()" class="text-xs opacity-80 hover:opacity-100 underline">
                                    <span id="toggleText">Show full number</span>
                                </button>
                            </div>

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

                    <!-- CVV Display -->
                    <div class="mt-4 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">CVV</p>
                                <p class="text-lg font-mono font-bold text-gray-900" id="cvv">***</p>
                            </div>
                            <button onclick="toggleCVV()" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-xs font-medium">
                                <span id="cvvToggleText">Show</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card Info & Actions -->
                <div class="space-y-4">
                    <!-- Spending Limits -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Spending Limits</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-xs mb-2">
                                    <span class="text-gray-600">Daily Limit</span>
                                    <span class="font-semibold text-gray-900">${{ number_format($card->daily_spent, 2) }} / ${{ number_format($card->daily_limit, 2) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $card->daily_limit > 0 ? min(($card->daily_spent / $card->daily_limit) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs mb-2">
                                    <span class="text-gray-600">Monthly Limit</span>
                                    <span class="font-semibold text-gray-900">${{ number_format($card->monthly_spent, 2) }} / ${{ number_format($card->monthly_limit, 2) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $card->monthly_limit > 0 ? min(($card->monthly_spent / $card->monthly_limit) * 100, 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        <button onclick="document.getElementById('limitsModal').classList.remove('hidden')" class="mt-4 w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-xs font-medium">
                            Update Limits
                        </button>
                    </div>

                    <!-- Card Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Card Actions</h3>
                        
                        <div class="space-y-2">
                            @if($card->status === 'active')
                                <form action="{{ route('cards.freeze', $card) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 text-xs font-medium flex items-center justify-center gap-2">
                                        <i data-lucide="snowflake" class="w-4 h-4"></i>
                                        Freeze Card
                                    </button>
                                </form>
                            @elseif($card->status === 'frozen')
                                <form action="{{ route('cards.unfreeze', $card) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 text-xs font-medium flex items-center justify-center gap-2">
                                        <i data-lucide="unlock" class="w-4 h-4"></i>
                                        Unfreeze Card
                                    </button>
                                </form>
                            @endif

                            @if($card->status !== 'cancelled')
                                <form action="{{ route('cards.cancel', $card) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this card? This action cannot be undone.')">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 text-xs font-medium flex items-center justify-center gap-2">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        Cancel Card
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Card Info -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Card Information</h3>
                        
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created</span>
                                <span class="font-medium text-gray-900">{{ $card->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Linked Account</span>
                                <span class="font-medium text-gray-900 font-mono">{{ $card->account->account_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Card Type</span>
                                <span class="font-medium text-gray-900">{{ ucfirst($card->card_type) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Limits Modal -->
    <div id="limitsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Update Spending Limits</h3>
                <button onclick="document.getElementById('limitsModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="{{ route('cards.update-limits', $card) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Daily Limit</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2 text-xs text-gray-500">$</span>
                        <input type="number" name="daily_limit" value="{{ $card->daily_limit }}" min="100" max="10000" step="100" required
                               class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-medium text-gray-700 mb-2">Monthly Limit</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2 text-xs text-gray-500">$</span>
                        <input type="number" name="monthly_limit" value="{{ $card->monthly_limit }}" min="1000" max="100000" step="1000" required
                               class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <button type="submit" class="w-full py-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-lg hover:from-purple-700 hover:to-purple-800 text-xs font-semibold">
                    Update Limits
                </button>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        let cardNumberVisible = false;
        let cvvVisible = false;

        function toggleCardNumber() {
            const cardNumberEl = document.getElementById('cardNumber');
            const toggleText = document.getElementById('toggleText');
            
            if (cardNumberVisible) {
                cardNumberEl.textContent = '{{ $card->masked_card_number }}';
                toggleText.textContent = 'Show full number';
            } else {
                cardNumberEl.textContent = '{{ chunk_split($card->card_number, 4, " ") }}';
                toggleText.textContent = 'Hide full number';
            }
            
            cardNumberVisible = !cardNumberVisible;
        }

        function toggleCVV() {
            const cvvEl = document.getElementById('cvv');
            const toggleText = document.getElementById('cvvToggleText');
            
            if (cvvVisible) {
                cvvEl.textContent = '***';
                toggleText.textContent = 'Show';
            } else {
                cvvEl.textContent = '{{ $card->cvv }}';
                toggleText.textContent = 'Hide';
            }
            
            cvvVisible = !cvvVisible;
        }
    </script>
@endsection
