@extends('layouts.app')

@section('title', 'Contact Us - Courier Savings Bank')

@section('content')
<!-- Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 pt-4 px-4">
    <div class="max-w-6xl mx-auto bg-white/95 backdrop-blur-md shadow-lg rounded-2xl">
        <div class="px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('logo.svg') }}" alt="Logo" class="w-9 h-9">
                    <span class="text-lg font-bold text-gray-900">Courier Savings Bank</span>
                </div>
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
<section class="pt-32 pb-16 bg-gradient-to-br from-[#6B2D9E] to-[#5A2589]">
    <div class="max-w-4xl mx-auto px-6 text-center text-white">
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Get in Touch</h1>
        <p class="text-lg text-purple-100">We're here to help. Reach out to us anytime.</p>
    </div>
</section>

<!-- Contact Content -->
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-sm"
                               placeholder="John Doe">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-sm"
                               placeholder="john@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                        <input type="text" name="subject" required
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-sm"
                               placeholder="How can we help?">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                        <textarea name="message" rows="5" required
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none text-sm"
                                  placeholder="Tell us more about your inquiry..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-3 px-6 rounded-lg transition shadow-lg text-sm">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Contact Information</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <x-icons name="mail" class="w-6 h-6 text-primary" />
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm mb-1">Email</p>
                                <a href="mailto:support@couriersavingsbank.com" class="text-primary hover:underline text-sm">
                                    support@couriersavingsbank.com
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <x-icons name="phone" class="w-6 h-6 text-primary" />
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm mb-1">Phone</p>
                                <p class="text-gray-600 text-sm">1-800-COURIER (268-7437)</p>
                                <p class="text-xs text-gray-500 mt-1">Mon-Fri: 8AM - 8PM EST</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <x-icons name="map-pin" class="w-6 h-6 text-primary" />
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm mb-1">Headquarters</p>
                                <p class="text-gray-600 text-sm">
                                    123 Financial District<br>
                                    New York, NY 10004<br>
                                    United States
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <x-icons name="clock" class="w-6 h-6 text-primary" />
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm mb-1">Business Hours</p>
                                <p class="text-gray-600 text-sm">
                                    Monday - Friday: 8:00 AM - 8:00 PM EST<br>
                                    Saturday: 9:00 AM - 5:00 PM EST<br>
                                    Sunday: Closed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 border-2 border-purple-200 rounded-2xl p-6">
                    <h4 class="font-bold text-gray-900 mb-3 text-sm">Need Immediate Assistance?</h4>
                    <p class="text-gray-600 text-sm mb-4">
                        For urgent account issues or fraud reports, please call our 24/7 emergency hotline:
                    </p>
                    <p class="text-2xl font-bold text-primary">1-800-911-BANK</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
@include('partials.footer')
@endsection
