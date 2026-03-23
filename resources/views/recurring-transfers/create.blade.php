@extends('layouts.dashboard')

@section('title', 'Create Recurring Transfer - Courier Savings Bank')

@section('content')
<div class="mb-5 flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Create Recurring Transfer</h1>
        <p class="text-gray-600 mt-1 text-xs">Set up automatic transfers on a schedule</p>
    </div>
    <a href="{{ route('recurring-transfers.index') }}" class="inline-flex items-center text-primary hover:text-primary-dark font-semibold transition text-xs px-4 py-2 bg-purple-50 rounded-lg">
        <x-icons name="arrow-left" class="w-3.5 h-3.5 mr-1.5" />
        Back
    </a>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <form action="{{ route('recurring-transfers.store') }}" method="POST">
            @csrf
            
            <!-- Recipient Selection -->
            @if($beneficiaries->count() > 0)
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Quick Select Beneficiary</label>
                    <select id="beneficiary-select" class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs">
                        <option value="">-- Select a beneficiary --</option>
                        @foreach($beneficiaries as $beneficiary)
                            <option value="{{ $beneficiary->id }}" 
                                data-name="{{ $beneficiary->name }}" 
                                data-account="{{ $beneficiary->account_number }}">
                                {{ $beneficiary->name }} ({{ $beneficiary->account_number }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Recipient Name *</label>
                    <input type="text" name="recipient_name" id="recipient_name" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        value="{{ old('recipient_name') }}">
                    @error('recipient_name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Account Number *</label>
                    <input type="text" name="recipient_account" id="recipient_account" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs font-mono"
                        value="{{ old('recipient_account') }}">
                    @error('recipient_account')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Amount *</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-xs font-bold">$</span>
                        <input type="number" name="amount" step="0.01" min="1" max="50000" required
                            class="w-full pl-9 pr-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs font-semibold"
                            value="{{ old('amount') }}">
                    </div>
                    @error('amount')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Frequency *</label>
                    <select name="frequency" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs">
                        <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="biweekly" {{ old('frequency') == 'biweekly' ? 'selected' : '' }}>Bi-weekly</option>
                        <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }} selected>Monthly</option>
                        <option value="quarterly" {{ old('frequency') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                    @error('frequency')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Start Date *</label>
                    <input type="date" name="start_date" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        value="{{ old('start_date', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}">
                    @error('start_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">End Date (Optional)</label>
                    <input type="date" name="end_date"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        value="{{ old('end_date') }}">
                    @error('end_date')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Max Executions (Optional)</label>
                    <input type="number" name="max_executions" min="1"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        value="{{ old('max_executions') }}" placeholder="Unlimited">
                    @error('max_executions')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-gray-700 font-semibold mb-2 text-xs">Description (Optional)</label>
                <textarea name="description" rows="2"
                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none text-xs"
                    placeholder="e.g., Monthly rent payment">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-5">
                <div class="flex items-start">
                    <div class="w-7 h-7 bg-yellow-100 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                        <x-icons name="alert-triangle" class="w-3.5 h-3.5 text-yellow-600" />
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1 text-xs">Important Information</h4>
                        <ul class="text-xs text-gray-700 space-y-0.5">
                            <li>• Ensure sufficient balance before each execution date</li>
                            <li>• Transfers will execute automatically on schedule</li>
                            <li>• You can pause or cancel anytime</li>
                            <li>• Failed transfers due to insufficient funds will be skipped</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex space-x-2.5">
                <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-2.5 px-5 rounded-lg transition shadow-lg flex items-center justify-center space-x-1.5 text-xs">
                    <x-icons name="check" class="w-3.5 h-3.5" />
                    <span>Create Recurring Transfer</span>
                </button>
                <a href="{{ route('recurring-transfers.index') }}" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition text-xs">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('beneficiary-select')?.addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    if (selected.value) {
        document.getElementById('recipient_name').value = selected.dataset.name;
        document.getElementById('recipient_account').value = selected.dataset.account;
    }
});
</script>
@endsection
