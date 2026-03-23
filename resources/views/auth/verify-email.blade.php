@extends('layouts.app')

@section('title', 'Verify your email - Courier Savings Bank')

@section('content')
<div class="min-h-screen flex items-center justify-center p-8 bg-gray-50">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <div class="inline-block bg-purple-100 text-primary px-3 py-1 rounded-full text-xs font-bold mb-3">
                VERIFY EMAIL
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-1">Check your inbox</h1>
            <p class="text-sm text-gray-600">
                We sent a verification link to <span class="font-semibold text-gray-800">{{ auth()->user()->email }}</span>.
                Click the link in that email to activate your account. You must verify before you can use the dashboard.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-3 py-2 rounded-lg text-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('status') === 'verification-link-sent')
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-3 py-2 rounded-lg text-xs">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-3 py-2 rounded-lg text-xs">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p class="text-xs text-gray-600">
                Didn’t receive the email? Check spam/junk, then resend the verification message.
            </p>

            <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
                @csrf
                <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-4 rounded-lg transition text-sm shadow-lg">
                    Resend verification email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-gray-100">
                @csrf
                <button type="submit" class="w-full text-xs text-gray-600 hover:text-primary font-medium py-2">
                    Sign out and use a different email
                </button>
            </form>

            <p class="text-center text-xs text-gray-500">
                <a href="{{ route('home') }}" class="hover:text-primary font-medium">← Back to homepage</a>
            </p>
        </div>
    </div>
</div>
@endsection
