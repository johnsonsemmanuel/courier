@extends('layouts.app')

@section('title', 'Welcome - Courier Savings Bank')

@section('content')
<!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 pt-6 px-4">
    <div class="max-w-6xl mx-auto bg-white/95 backdrop-blur-md shadow-lg rounded-2xl">
        <div class="px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('logo.svg') }}" alt="Logo" class="w-9 h-9">
                    <span class="text-lg font-bold text-gray-900">Courier Savings Bank</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('pages.personal') }}" class="text-sm text-gray-700 hover:text-primary font-medium transition">Personal</a>
                    <a href="{{ route('pages.business') }}" class="text-sm text-gray-700 hover:text-primary font-medium transition">Business</a>
                    <a href="{{ route('pages.loans') }}" class="text-sm text-gray-700 hover:text-primary font-medium transition">Loans</a>
                    <a href="{{ route('pages.investments') }}" class="text-sm text-gray-700 hover:text-primary font-medium transition">Investments</a>
                    <a href="{{ route('pages.support') }}" class="text-sm text-gray-700 hover:text-primary font-medium transition">Support</a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-primary font-semibold transition">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-5 py-2 rounded-lg transition">
                        Open Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-[#6B2D9E] via-[#7B3FA8] to-[#5A2589] overflow-hidden" style="padding-top: 180px; padding-bottom: 32px;">
    <!-- Decorative Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-300 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-400 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-12 lg:py-16 mb-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Left Content -->
            <div class="text-white space-y-6">
                <div class="inline-block bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/20">
                    <span class="text-sm font-medium">Trusted by 50,000+ customers worldwide</span>
                </div>
                
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight">
                    Banking Made Simple,<br/>
                    <span class="text-purple-200">Secure & Accessible</span>
                </h1>
                
                <p class="text-lg text-purple-100 leading-relaxed max-w-xl">
                    Experience modern banking with instant transfers, competitive rates, and 24/7 access to your money. Open your account in minutes.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-primary font-semibold px-6 py-3 rounded-lg transition flex items-center space-x-2 shadow-lg text-sm">
                        <span>Open Free Account</span>
                        <x-icons name="arrow-right" class="w-4 h-4" />
                    </a>
                    <a href="{{ route('login') }}" class="bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-semibold px-6 py-3 rounded-lg transition border border-white/30 text-sm">
                        Sign In to Account
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap items-center gap-6 pt-4">
                    <div class="flex items-center space-x-2">
                        <x-icons name="shield-check" class="w-5 h-5 text-green-300" />
                        <span class="text-sm text-purple-100">FDIC Insured</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-icons name="check" class="w-5 h-5 text-green-300" />
                        <span class="text-sm text-purple-100">256-bit Encryption</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <x-icons name="zap" class="w-5 h-5 text-green-300" />
                        <span class="text-sm text-purple-100">Instant Transfers</span>
                    </div>
                </div>
            </div>

            <!-- Right Content - Account Card -->
            <div class="hidden lg:flex justify-center">
                <div class="bg-white rounded-2xl shadow-2xl p-6 transform hover:scale-105 transition duration-300 w-full max-w-md">
                    <!-- Card Header -->
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Available Balance</p>
                            <p class="text-3xl font-bold text-gray-900">$24,580.50</p>
                        </div>
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                            <x-icons name="check" class="w-6 h-6 text-green-600" />
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] rounded-xl p-4 mb-5">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <p class="text-xs text-purple-200 mb-1">Account Holder</p>
                                <p class="text-sm font-semibold text-white">John Anderson</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-purple-200 mb-1">Account Type</p>
                                <p class="text-sm font-semibold text-white">Savings</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-purple-200 mb-1">Account Number</p>
                            <p class="text-sm font-mono font-semibold text-white tracking-wider">•••• •••• •••• 4892</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="grid grid-cols-3 gap-2">
                        <button class="bg-purple-50 hover:bg-purple-100 rounded-lg p-3 transition text-center">
                            <x-icons name="dollar-sign" class="w-5 h-5 text-primary mx-auto mb-1" />
                            <span class="text-xs font-semibold text-gray-700">Send</span>
                        </button>
                        <button class="bg-purple-50 hover:bg-purple-100 rounded-lg p-3 transition text-center">
                            <x-icons name="arrow-right" class="w-5 h-5 text-primary mx-auto mb-1 transform rotate-180" />
                            <span class="text-xs font-semibold text-gray-700">Deposit</span>
                        </button>
                        <button class="bg-purple-50 hover:bg-purple-100 rounded-lg p-3 transition text-center">
                            <x-icons name="file-text" class="w-5 h-5 text-primary mx-auto mb-1" />
                            <span class="text-xs font-semibold text-gray-700">History</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-block bg-purple-100 text-primary px-4 py-1.5 rounded-full text-xs font-bold mb-4">
                FEATURES
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                Everything You Need in One Place
            </h2>
            <p class="text-base text-gray-600 max-w-2xl mx-auto">
                Modern banking features designed for your financial success
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <x-icons name="zap" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Instant Transfers</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Send and receive money instantly with zero fees. Transfer funds 24/7 to any account.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <x-icons name="shield-check" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Bank-Level Security</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Your money is protected with 256-bit encryption and FDIC insurance up to $250,000.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <x-icons name="bar-chart" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Smart Savings</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Earn competitive interest rates on your savings with no minimum balance required.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <x-icons name="globe" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Global Access</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Access your account from anywhere in the world with our mobile and web platforms.
                </p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <x-icons name="users" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">24/7 Support</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Get help whenever you need it with our round-the-clock customer support team.
                </p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <x-icons name="file-text" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Easy Tracking</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Monitor all your transactions in real-time with detailed statements and analytics.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-block bg-purple-100 text-primary px-4 py-1.5 rounded-full text-xs font-bold mb-4">
                TRUSTED BY THOUSANDS
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3">
                Banking You Can Trust
            </h2>
        </div>
        <div class="grid md:grid-cols-4 gap-8 text-center">
            <div>
                <p class="text-4xl font-bold text-primary mb-2">50K+</p>
                <p class="text-sm text-gray-600 font-medium">Active Customers</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-primary mb-2">$2.5B+</p>
                <p class="text-sm text-gray-600 font-medium">Transactions Processed</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-primary mb-2">99.9%</p>
                <p class="text-sm text-gray-600 font-medium">Uptime Guarantee</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-primary mb-2">150+</p>
                <p class="text-sm text-gray-600 font-medium">Countries Supported</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-br from-primary to-primary-dark">
    <div class="max-w-4xl mx-auto px-6 text-center text-white">
        <div class="inline-block bg-white/20 backdrop-blur-sm text-white px-4 py-1.5 rounded-full text-xs font-bold mb-4 border border-white/30">
            GET STARTED TODAY
        </div>
        <h2 class="text-3xl lg:text-4xl font-bold mb-4">
            Ready to Take Control of Your Finances?
        </h2>
        <p class="text-base text-purple-100 mb-8 leading-relaxed">
            Join thousands of customers who trust Courier Savings Bank for secure, modern banking.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('register') }}" class="bg-white text-primary hover:bg-gray-100 font-bold px-8 py-3 rounded-lg transition shadow-lg text-sm inline-flex items-center space-x-2">
                <span>Open Your Free Account</span>
                <x-icons name="arrow-right" class="w-4 h-4" />
            </a>
            <a href="{{ route('login') }}" class="bg-white/10 backdrop-blur-sm text-white hover:bg-white/20 font-bold px-8 py-3 rounded-lg transition border-2 border-white/30 text-sm">
                Sign In
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
@include('partials.footer')
@endsection
