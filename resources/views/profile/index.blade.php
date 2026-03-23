@extends('layouts.dashboard')

@section('title', 'Profile - Courier Savings Bank')

@section('content')
<div class="mb-5">
        <div class="inline-block bg-purple-100 text-primary px-3 py-1 rounded-full text-xs font-bold mb-2">
            PROFILE SETTINGS
        </div>
        <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
        <p class="text-gray-600 mt-1 text-xs">Manage your account information</p>
    </div>

    <div class="max-w-6xl">
        <div class="grid md:grid-cols-3 gap-5">
        <!-- Profile Info Card -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-[#6B2D9E] to-[#5A2589] rounded-full flex items-center justify-center text-white font-bold text-xl mx-auto mb-2.5">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 class="font-bold text-gray-900 text-sm">{{ $user->name }}</h3>
                <p class="text-xs text-gray-600">{{ $user->email }}</p>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <p class="text-xs text-gray-500 mb-0.5">Member Since</p>
                    <p class="text-xs font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Forms -->
        <div class="md:col-span-2 space-y-4">
            <!-- Update Profile -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Personal Information</h3>
                
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-3 py-2 text-xs border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-3 py-2 text-xs border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                        @error('email')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" required
                            class="w-full px-3 py-2 text-xs border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                        @error('phone')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Address</label>
                        <textarea name="address" rows="2" required
                            class="w-full px-3 py-2 text-xs border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-5 rounded-lg transition text-xs shadow-lg">
                        Update Profile
                    </button>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Change Password</h3>
                
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" required
                            class="w-full px-3 py-2 text-xs border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                        @error('current_password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" required
                            class="w-full px-3 py-2 text-xs border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                        @error('password')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-3 py-2 text-xs border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition">
                    </div>

                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-5 rounded-lg transition text-xs shadow-lg">
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
