@extends('layouts.app')

@section('title', 'Login - Courier Savings Bank')

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
                Welcome Back to Your Financial Hub
            </h1>
            <p class="text-lg text-purple-100 mb-8 leading-relaxed">
                Access your account securely and manage your finances with ease.
            </p>

            <!-- Feature Cards -->
            <div class="space-y-3">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <x-icons name="shield-check" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Secure & Protected</p>
                            <p class="text-xs text-purple-200">Bank-grade encryption</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <x-icons name="zap" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Instant Access</p>
                            <p class="text-xs text-purple-200">24/7 availability</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <x-icons name="globe" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Global Banking</p>
                            <p class="text-xs text-purple-200">Access from anywhere</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="w-full max-w-md">
            <div class="mb-6">
                <div class="inline-block bg-purple-100 text-primary px-3 py-1 rounded-full text-xs font-bold mb-3">
                    SIGN IN
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Welcome Back</h2>
                <p class="text-sm text-gray-600">Sign in to access your account</p>
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

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
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

                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               required 
                               class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition"
                               placeholder="Enter your password">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input id="remember" 
                                   name="remember" 
                                   type="checkbox" 
                                   class="w-3.5 h-3.5 text-primary focus:ring-primary border-gray-300 rounded">
                            <span class="ml-2 text-xs text-gray-700">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-xs text-primary hover:text-primary-dark font-semibold">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 rounded-lg transition text-sm shadow-lg">
                        Sign In
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-primary font-bold hover:text-primary-dark">
                            Create account
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
