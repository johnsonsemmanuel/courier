@extends('layouts.app')

@section('title', '500 - Server Error')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="text-center">
        <div class="mb-6">
            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <x-icons name="x" class="w-12 h-12 text-red-600" />
            </div>
            <h1 class="text-6xl font-bold text-gray-900 mb-2">500</h1>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Server Error</h2>
            <p class="text-gray-600 mb-6">Something went wrong on our end. We're working to fix it.</p>
        </div>
        
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-lg transition text-sm inline-flex items-center space-x-2">
                <x-icons name="home" class="w-4 h-4" />
                <span>Go Home</span>
            </a>
            <button onclick="window.location.reload()" class="bg-white hover:bg-gray-100 text-gray-700 font-semibold px-6 py-3 rounded-lg transition text-sm border-2 border-gray-300">
                Try Again
            </button>
        </div>
    </div>
</div>
@endsection
