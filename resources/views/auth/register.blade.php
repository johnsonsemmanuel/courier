@extends('layouts.app')

@section('title', 'Register - Courier Savings Bank')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Image/Branding -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#6B2D9E] via-[#7B3FA8] to-[#5A2589] relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 flex flex-col justify-center px-12 text-white">
            <div class="flex items-center space-x-2 mb-8">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <x-icons name="dollar-sign" class="w-6 h-6 text-primary" />
                </div>
                <span class="text-xl font-bold">Courier Savings Bank</span>
            </div>

            <h1 class="text-4xl font-bold mb-4 leading-tight">
                Start Your Financial Journey Today
            </h1>
            <p class="text-lg text-purple-100 mb-8 leading-relaxed">
                Join thousands of customers who trust us for secure, modern banking.
            </p>

            <!-- Benefits -->
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <x-icons name="check" class="w-5 h-5 text-white" />
                    </div>
                    <p class="text-sm">Free account setup in minutes</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <x-icons name="check" class="w-5 h-5 text-white" />
                    </div>
                    <p class="text-sm">Bank-grade security & encryption</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <x-icons name="check" class="w-5 h-5 text-white" />
                    </div>
                    <p class="text-sm">24/7 customer support</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <x-icons name="check" class="w-5 h-5 text-white" />
                    </div>
                    <p class="text-sm">FDIC insured up to $250,000</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Register Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="w-full max-w-md">
            <div class="mb-6">
                <div class="inline-block bg-purple-100 text-primary px-3 py-1 rounded-full text-xs font-bold mb-3">
                    CREATE ACCOUNT
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Get Started</h2>
                <p class="text-sm text-gray-600">Create your free account</p>
                <p class="text-xs text-gray-500 mt-2">We’ll email you a verification link. You must confirm your email before accessing your dashboard.</p>
            </div>

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

                <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-700 mb-1.5">Full Name</label>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               required 
                               autofocus 
                               class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition" 
                               value="{{ old('name') }}"
                               placeholder="John Doe">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address</label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               required 
                               class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition" 
                               value="{{ old('email') }}"
                               placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-semibold text-gray-700 mb-1.5">Phone Number</label>
                        <input id="phone" 
                               name="phone" 
                               type="tel" 
                               required 
                               class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition" 
                               value="{{ old('phone') }}"
                               placeholder="+1 (555) 000-0000">
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-semibold text-gray-700 mb-1.5">Address</label>
                        <textarea id="address" 
                                  name="address" 
                                  required 
                                  rows="2"
                                  class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none"
                                  placeholder="123 Main St, City, State, ZIP">{{ old('address') }}</textarea>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
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

                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 rounded-lg transition text-sm shadow-lg mt-4">
                        Create Account
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-primary font-bold hover:text-primary-dark">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-xs text-gray-600 hover:text-primary font-medium">
                    ← Back to homepage
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
