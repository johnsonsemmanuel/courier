@extends('layouts.app')

@section('title', 'Forgot Password - Courier Savings Bank')

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
                RESET PASSWORD
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-1">Forgot Password?</h2>
            <p class="text-sm text-gray-600">Enter your email to receive a reset link</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-3 py-2 rounded-lg">
                    <p class="text-xs">{{ session('success') }}</p>
                    @if(session('reset_token'))
                        <a href="{{ route('password.reset', ['token' => session('reset_token'), 'email' => session('reset_email')]) }}" 
                           class="text-xs font-bold underline mt-2 block">
                            Click here to reset your password (Demo Link)
                        </a>
                    @endif
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-3 py-2 rounded-lg">
                    <ul class="text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input id="email" 
                           name="email" 
                           type="email" 
                           required 
                           autofocus 
                           class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition" 
                           value="{{ old('email') }}"
                           placeholder="you@example.com">
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 rounded-lg transition text-sm shadow-lg">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-xs text-primary hover:text-primary-dark font-semibold flex items-center justify-center space-x-1">
                    <x-icons name="arrow-right" class="w-3 h-3 transform rotate-180" />
                    <span>Back to login</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
