@extends('layouts.app')

@section('title', 'Reset Password - Courier Savings Bank')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-8 px-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center space-x-2 mb-4">
                <div class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center">
                    <x-icons name="dollar-sign" class="w-5 h-5 text-white" />
                </div>
                <span class="text-lg font-bold text-gray-900">Courier Savings Bank</span>
            </div>
            <div class="inline-block bg-purple-100 text-primary px-3 py-1 rounded-full text-xs font-bold mb-2">
                NEW PASSWORD
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Reset Password</h2>
            <p class="text-sm text-gray-600">Enter your new password</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-3 py-2 rounded-lg">
                    <ul class="text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ request('email') }}">

                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input id="email" 
                           type="email" 
                           readonly
                           class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ request('email') }}">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-700 mb-1.5">New Password</label>
                    <input id="password" 
                           name="password" 
                           type="password" 
                           required 
                           autofocus
                           class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition"
                           placeholder="Minimum 8 characters">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                    <input id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           required 
                           class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition"
                           placeholder="Re-enter password">
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 rounded-lg transition text-sm shadow-lg">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
