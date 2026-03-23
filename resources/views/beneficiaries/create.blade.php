@extends('layouts.dashboard')

@section('title', 'Add Beneficiary - Courier Savings Bank')

@section('content')
<div class="mb-5 flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Add Beneficiary</h1>
        <p class="text-gray-600 mt-1 text-xs">Save a beneficiary for quick transfers</p>
    </div>
    <a href="{{ route('beneficiaries.index') }}" class="inline-flex items-center text-primary hover:text-primary-dark font-semibold transition text-xs px-4 py-2 bg-purple-50 rounded-lg">
        <x-icons name="arrow-left" class="w-3.5 h-3.5 mr-1.5" />
        Back
    </a>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <form action="{{ route('beneficiaries.store') }}" method="POST">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Full Name *</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        placeholder="John Doe" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Nickname (Optional)</label>
                    <input type="text" name="nickname"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        placeholder="e.g., Brother, Mom" value="{{ old('nickname') }}">
                    @error('nickname')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Account Number *</label>
                    <input type="text" name="account_number" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs font-mono"
                        placeholder="1234567890" value="{{ old('account_number') }}">
                    @error('account_number')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Bank Name *</label>
                    <select name="bank_name" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs">
                        <option value="Courier Savings Bank" {{ old('bank_name') == 'Courier Savings Bank' ? 'selected' : '' }}>Courier Savings Bank</option>
                        <option value="Chase Bank" {{ old('bank_name') == 'Chase Bank' ? 'selected' : '' }}>Chase Bank</option>
                        <option value="Bank of America" {{ old('bank_name') == 'Bank of America' ? 'selected' : '' }}>Bank of America</option>
                        <option value="Wells Fargo" {{ old('bank_name') == 'Wells Fargo' ? 'selected' : '' }}>Wells Fargo</option>
                        <option value="Citibank" {{ old('bank_name') == 'Citibank' ? 'selected' : '' }}>Citibank</option>
                        <option value="HSBC" {{ old('bank_name') == 'HSBC' ? 'selected' : '' }}>HSBC</option>
                        <option value="Other" {{ old('bank_name') == 'Other' ? 'selected' : '' }}>Other Bank</option>
                    </select>
                    @error('bank_name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Email (Optional)</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        placeholder="john@example.com" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Phone (Optional)</label>
                    <input type="tel" name="phone"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        placeholder="+1 234 567 8900" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-purple-50 border border-purple-200 rounded-lg p-3 mb-5">
                <div class="flex items-start">
                    <div class="w-7 h-7 bg-purple-100 rounded-lg flex items-center justify-center mr-2.5 flex-shrink-0">
                        <x-icons name="info" class="w-3.5 h-3.5 text-primary" />
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1 text-xs">Beneficiary Information</h4>
                        <ul class="text-xs text-gray-700 space-y-0.5">
                            <li>• Verify account details before saving</li>
                            <li>• For internal transfers, account must exist</li>
                            <li>• You can add beneficiaries from other banks</li>
                            <li>• Nicknames help you identify beneficiaries quickly</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex space-x-2.5">
                <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-2.5 px-5 rounded-lg transition shadow-lg flex items-center justify-center space-x-1.5 text-xs">
                    <x-icons name="check" class="w-3.5 h-3.5" />
                    <span>Save Beneficiary</span>
                </button>
                <a href="{{ route('beneficiaries.index') }}" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition text-xs">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
