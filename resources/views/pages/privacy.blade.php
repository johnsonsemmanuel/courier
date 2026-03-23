@extends('layouts.app')

@section('title', 'Privacy Policy - Courier Savings Bank')

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
        <h1 class="text-4xl lg:text-5xl font-bold mb-4">Privacy Policy</h1>
        <p class="text-lg text-purple-100">Last updated: {{ date('F d, Y') }}</p>
    </div>
</section>

<!-- Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">
        <div class="prose prose-sm max-w-none">
            <div class="bg-purple-50 border-l-4 border-primary p-6 rounded-lg mb-8">
                <p class="text-sm text-gray-700 leading-relaxed">
                    At Courier Savings Bank, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, and safeguard your data.
                </p>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">1. Information We Collect</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-4">
                We collect information that you provide directly to us, including:
            </p>
            <ul class="list-disc pl-6 text-sm text-gray-700 space-y-2 mb-6">
                <li>Personal identification information (name, email address, phone number, address)</li>
                <li>Financial information (account numbers, transaction history)</li>
                <li>Government-issued identification documents</li>
                <li>Employment and income information</li>
                <li>Device and usage information when you access our services</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">2. How We Use Your Information</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-4">
                We use the information we collect to:
            </p>
            <ul class="list-disc pl-6 text-sm text-gray-700 space-y-2 mb-6">
                <li>Provide, maintain, and improve our banking services</li>
                <li>Process transactions and send related information</li>
                <li>Verify your identity and prevent fraud</li>
                <li>Comply with legal and regulatory requirements</li>
                <li>Send you technical notices, updates, and support messages</li>
                <li>Respond to your comments and questions</li>
                <li>Analyze usage patterns to improve our services</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">3. Information Sharing and Disclosure</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-4">
                We do not sell your personal information. We may share your information in the following circumstances:
            </p>
            <ul class="list-disc pl-6 text-sm text-gray-700 space-y-2 mb-6">
                <li><strong>With your consent:</strong> When you explicitly authorize us to share information</li>
                <li><strong>Service providers:</strong> With third-party vendors who perform services on our behalf</li>
                <li><strong>Legal compliance:</strong> When required by law or to respond to legal processes</li>
                <li><strong>Fraud prevention:</strong> To protect against fraud and unauthorized transactions</li>
                <li><strong>Business transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">4. Data Security</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                We implement industry-standard security measures to protect your information, including:
            </p>
            <ul class="list-disc pl-6 text-sm text-gray-700 space-y-2 mb-6">
                <li>256-bit SSL encryption for data transmission</li>
                <li>Secure data storage with encryption at rest</li>
                <li>Regular security audits and penetration testing</li>
                <li>Multi-factor authentication options</li>
                <li>Employee training on data protection practices</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">5. Your Rights and Choices</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-4">
                You have the following rights regarding your personal information:
            </p>
            <ul class="list-disc pl-6 text-sm text-gray-700 space-y-2 mb-6">
                <li><strong>Access:</strong> Request a copy of your personal information</li>
                <li><strong>Correction:</strong> Update or correct inaccurate information</li>
                <li><strong>Deletion:</strong> Request deletion of your information (subject to legal requirements)</li>
                <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
                <li><strong>Data portability:</strong> Request your data in a portable format</li>
            </ul>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">6. Cookies and Tracking Technologies</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                We use cookies and similar technologies to enhance your experience, analyze usage, and deliver personalized content. You can control cookie preferences through your browser settings.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">7. Children's Privacy</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                Our services are not directed to individuals under 18 years of age. We do not knowingly collect personal information from children.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">8. Changes to This Policy</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-6">
                We may update this Privacy Policy from time to time. We will notify you of any material changes by posting the new policy on our website and updating the "Last updated" date.
            </p>

            <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">9. Contact Us</h2>
            <p class="text-sm text-gray-700 leading-relaxed mb-4">
                If you have questions about this Privacy Policy or our privacy practices, please contact us:
            </p>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                <p class="text-sm text-gray-700">
                    <strong>Email:</strong> privacy@couriersavingsbank.com<br>
                    <strong>Phone:</strong> 1-800-COURIER (268-7437)<br>
                    <strong>Mail:</strong> Privacy Officer, Courier Savings Bank, 123 Financial District, New York, NY 10004
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
@include('partials.footer')
@endsection
