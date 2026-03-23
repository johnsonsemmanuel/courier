@extends('layouts.app')

@section('title', '404 - Page Not Found')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="text-center">
        <div class="mb-6">
            <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <x-icons name="alert-triangle" class="w-12 h-12 text-primary" />
            </div>
            <h1 class="text-6xl font-bold text-gray-900 mb-2">404</h1>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Page Not Found</h2>
            <p class="text-gray-600 mb-6">The page you're looking for doesn't exist or has been moved.</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-lg transition text-sm inline-flex items-center space-x-2">
                <x-icons name="home" class="w-4 h-4" />
                <span>Go Home</span>
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold px-6 py-3 rounded-lg transition text-sm border-2 border-gray-300">
                    Go to Dashboard
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
