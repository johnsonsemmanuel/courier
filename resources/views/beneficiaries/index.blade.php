@extends('layouts.dashboard')

@section('title', 'Beneficiaries - Courier Savings Bank')

@section('content')
<!-- Header -->
<div class="flex justify-between items-start mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Beneficiaries</h1>
        <p class="text-gray-600 mt-1 text-xs">Manage your saved beneficiaries for quick transfers</p>
    </div>
    <a href="{{ route('beneficiaries.create') }}" class="bg-primary hover:bg-primary-dark text-white font-semibold px-4 py-2 rounded-lg transition text-xs shadow-lg flex items-center space-x-1.5">
        <x-icons name="users" class="w-4 h-4" />
        <span>Add Beneficiary</span>
    </a>
</div>

@if($beneficiaries->count() > 0)
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($beneficiaries as $beneficiary)
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#6B2D9E] to-[#5A2589] rounded-lg flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr($beneficiary->name, 0, 1)) }}
                    </div>
                    <div class="flex space-x-1">
                        <a href="{{ route('beneficiaries.edit', $beneficiary) }}" class="text-gray-400 hover:text-primary transition">
                            <x-icons name="edit" class="w-4 h-4" />
                        </a>
                        <form action="{{ route('beneficiaries.destroy', $beneficiary) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this beneficiary?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                <x-icons name="x" class="w-4 h-4" />
                            </button>
                        </form>
                    </div>
                </div>
                
                <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $beneficiary->name }}</h3>
                @if($beneficiary->nickname)
                    <p class="text-xs text-gray-600 mb-2">{{ $beneficiary->nickname }}</p>
                @endif
                
                <div class="space-y-1.5 mb-4">
                    <div class="flex items-center text-xs text-gray-600">
                        <x-icons name="file-text" class="w-3 h-3 mr-1.5" />
                        <span class="font-mono">{{ $beneficiary->account_number }}</span>
                    </div>
                    <div class="flex items-center text-xs text-gray-600">
                        <x-icons name="home" class="w-3 h-3 mr-1.5" />
                        <span>{{ $beneficiary->bank_name }}</span>
                    </div>
                </div>
                
                <a href="{{ route('send-money') }}?beneficiary={{ $beneficiary->id }}" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-lg transition text-xs flex items-center justify-center space-x-1.5">
                    <x-icons name="dollar-sign" class="w-3.5 h-3.5" />
                    <span>Send Money</span>
                </a>
            </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-xl p-10 shadow-sm border border-gray-100 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <x-icons name="users" class="w-8 h-8 text-gray-400" />
        </div>
        <h3 class="text-base font-bold text-gray-900 mb-2">No Beneficiaries Yet</h3>
        <p class="text-xs text-gray-600 mb-5">Add beneficiaries for quick and easy transfers</p>
        <a href="{{ route('beneficiaries.create') }}" class="inline-flex items-center space-x-1.5 bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-lg transition text-xs">
            <x-icons name="users" class="w-4 h-4" />
            <span>Add Your First Beneficiary</span>
        </a>
    </div>
@endif
@endsection
