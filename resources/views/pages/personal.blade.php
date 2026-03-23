@extends('layouts.app')
@section('title', 'Personal Banking - Courier Savings Bank')
@section('content')
<nav class="fixed top-0 left-0 right-0 z-50 pt-4 px-4">
    <div class="max-w-6xl mx-auto bg-white/95 backdrop-blur-md shadow-lg rounded-2xl">
        <div class="px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('logo.svg') }}" alt="Logo" class="w-9 h-9">
                    <span class="text-lg font-bold text-gray-900">Courier Savings Bank</span>
                </a>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-primary font-semibold transition">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white text-sm font-semibold px-5 py-2 rounded-lg transition">Open Account</a>
                </div>
            </div>
        </div>
    </div>
</nav>

<section class="pt-32 pb-16 bg-gradient-to-br from-[#6B2D9E] to-[#5A2589]">
    <div class="max-w-4xl mx-auto px-6 text-center text-white">
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Personal Banking</h1>
        <p class="text-lg text-purple-100">Everything you need to manage your money, all in one place</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white border-2 border-gray-100 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Savings Account</h3>
                <p class="text-gray-600 mb-6">Earn competitive interest rates with no minimum balance required.</p>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">2.5% APY on all balances</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">No monthly maintenance fees</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">FDIC insured up to $250,000</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="inline-block bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-lg transition text-sm">
                    Open Savings Account
                </a>
            </div>

            <div class="bg-white border-2 border-gray-100 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Virtual Cards</h3>
                <p class="text-gray-600 mb-6">Create virtual debit cards for secure online shopping.</p>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Instant card generation</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Customizable spending limits</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Freeze/unfreeze anytime</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="inline-block bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-lg transition text-sm">
                    Get Started
                </a>
            </div>

            <div class="bg-white border-2 border-gray-100 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Bill Payments</h3>
                <p class="text-gray-600 mb-6">Pay all your bills in one place with automated scheduling.</p>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Save favorite payees</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Schedule recurring payments</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Payment history tracking</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="inline-block bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-lg transition text-sm">
                    Start Paying Bills
                </a>
            </div>

            <div class="bg-white border-2 border-gray-100 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Money Transfers</h3>
                <p class="text-gray-600 mb-6">Send money instantly to anyone, anywhere, anytime.</p>
                <ul class="space-y-3 mb-6">
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Instant transfers, zero fees</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Save beneficiaries</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <x-icons name="check" class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700">Transaction receipts</span>
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="inline-block bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-lg transition text-sm">
                    Send Money Now
                </a>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection
