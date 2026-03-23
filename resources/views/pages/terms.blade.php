@extends('layouts.app')

@section('title', 'Terms of Service - Courier Savings Bank')

@section('content')
<!-- Navigation -->
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
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Terms of Service</h1>
        <p class="text-lg text-purple-100">Last updated: {{ date('F d, Y') }}</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">
        <div class="prose prose-sm max-w-none">
            <div class="bg-purple-50 border-l-4 border-primary p-6 rounded-lg mb-8">
                <p class="text-sm text-gray-700 leading-relaxed">
                    These Terms of Service govern your use of Courier Savings Bank's services. By opening an account or using our services, you agree to these terms.
                </p>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Account Opening and Eligibility</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                To open an account, you must be at least 18 years old, a U.S. resident, and provide valid identification. We reserve the right to refuse service or close accounts that violate these terms.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. Account Security</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                You are responsible for maintaining the confidentiality of your account credentials. Notify us immediately of any unauthorized access. We are not liable for losses resulting from unauthorized use of your account if you fail to protect your credentials.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Transactions and Fees</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                All transactions are subject to our fee schedule. We reserve the right to modify fees with 30 days' notice. Insufficient funds may result in overdraft fees. Transaction limits apply to certain account types.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. FDIC Insurance</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                Deposits are insured by the FDIC up to $250,000 per depositor, per account ownership category. This insurance protects your funds in the event of bank failure.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Prohibited Activities</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-4">You may not use our services for:</p>
            <ul class="list-disc pl-6 text-sm text-gray-700 space-y-2 mb-6">
                <li>Illegal activities or money laundering</li>
                <li>Fraud or deceptive practices</li>
                <li>Violating sanctions or export control laws</li>
                <li>Unauthorized access to other accounts</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. Account Closure</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                Either party may close an account at any time. We may close accounts for violations of these terms, suspicious activity, or regulatory requirements. You will receive notice and remaining funds will be returned.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">7. Limitation of Liability</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                We are not liable for indirect, incidental, or consequential damages. Our liability is limited to the amount of the transaction in question, except where prohibited by law.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">8. Dispute Resolution</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                Disputes will be resolved through binding arbitration. You waive the right to participate in class action lawsuits. This agreement is governed by the laws of the State of New York.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">9. Contact Information</h2>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                <p class="text-sm text-gray-700">
                    <strong>Email:</strong> legal@couriersavingsbank.com<br>
                    <strong>Phone:</strong> 1-800-COURIER (268-7437)<br>
                    <strong>Mail:</strong> Legal Department, Courier Savings Bank, 123 Financial District, New York, NY 10004
                </p>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection
