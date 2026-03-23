@extends('layouts.dashboard')

@section('title', 'Edit Beneficiary - Courier Savings Bank')

@section('content')
<div class="mb-5 flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Beneficiary</h1>
        <p class="text-gray-600 mt-1 text-xs">Update beneficiary information</p>
    </div>
    <a href="{{ route('beneficiaries.index') }}" class="inline-flex items-center text-primary hover:text-primary-dark font-semibold transition text-xs px-4 py-2 bg-purple-50 rounded-lg">
        <x-icons name="arrow-left" class="w-3.5 h-3.5 mr-1.5" />
        Back
    </a>
</div>

<div class="max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <form action="{{ route('beneficiaries.update', $beneficiary) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Full Name *</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        value="{{ old('name', $beneficiary->name) }}">
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Nickname (Optional)</label>
                    <input type="text" name="nickname"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        value="{{ old('nickname', $beneficiary->nickname) }}">
                    @error('nickname')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2 text-xs">Account Number</label>
                <input type="text" disabled
                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg bg-gray-50 text-xs font-mono"
                    value="{{ $beneficiary->account_number }}">
                <p class="text-xs text-gray-500 mt-1">Account number cannot be changed</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2 text-xs">Bank Name</label>
                <input type="text" disabled
                    class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg bg-gray-50 text-xs"
                    value="{{ $beneficiary->bank_name }}">
                <p class="text-xs text-gray-500 mt-1">Bank name cannot be changed</p>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Email (Optional)</label>
                    <input type="email" name="email"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        value="{{ old('email', $beneficiary->email) }}">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Phone (Optional)</label>
                    <input type="tel" name="phone"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                        value="{{ old('phone', $beneficiary->phone) }}">
                    @error('phone')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex space-x-2.5">
                <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-2.5 px-5 rounded-lg transition shadow-lg flex items-center justify-center space-x-1.5 text-xs">
                    <x-icons name="check" class="w-3.5 h-3.5" />
                    <span>Update Beneficiary</span>
                </button>
                <a href="{{ route('beneficiaries.index') }}" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition text-xs">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
