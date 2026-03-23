@extends('layouts.app')
@section('title', 'About Us - Courier Savings Bank')
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
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">About Courier Savings Bank</h1>
        <p class="text-lg text-purple-100">Banking made simple, secure, and accessible for everyone</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                <p class="text-gray-700 leading-relaxed mb-4">
                    At Courier Savings Bank, we believe banking should be simple, transparent, and accessible to everyone. Founded with the vision of modernizing financial services, we combine cutting-edge technology with personalized customer service.
                </p>
                <p class="text-gray-700 leading-relaxed">
                    We're committed to providing secure, reliable banking solutions that empower individuals and businesses to achieve their financial goals.
                </p>
            </div>
            <div class="bg-purple-50 rounded-2xl p-8">
                <div class="grid grid-cols-2 gap-6">
                    <div class="text-center">
                        <p class="text-4xl font-bold text-primary mb-2">50K+</p>
                        <p class="text-sm text-gray-600">Active Customers</p>
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-bold text-primary mb-2">$2.5B+</p>
                        <p class="text-sm text-gray-600">Assets Under Management</p>
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-bold text-primary mb-2">99.9%</p>
                        <p class="text-sm text-gray-600">Uptime</p>
                    </div>
                    <div class="text-center">
                        <p class="text-4xl font-bold text-primary mb-2">150+</p>
                        <p class="text-sm text-gray-600">Countries Served</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white border-2 border-gray-100 rounded-2xl p-6">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <x-icons name="shield-check" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Security First</h3>
                <p class="text-sm text-gray-600">Bank-level encryption and FDIC insurance protect your funds 24/7.</p>
            </div>
            <div class="bg-white border-2 border-gray-100 rounded-2xl p-6">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <x-icons name="zap" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Instant Transfers</h3>
                <p class="text-sm text-gray-600">Send and receive money instantly with zero fees, anytime.</p>
            </div>
            <div class="bg-white border-2 border-gray-100 rounded-2xl p-6">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <x-icons name="users" class="w-6 h-6 text-primary" />
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">24/7 Support</h3>
                <p class="text-sm text-gray-600">Our dedicated team is always here to help you succeed.</p>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection
