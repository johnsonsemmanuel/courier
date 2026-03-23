<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Courier Savings Bank')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <div class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 z-30 lg:left-0">
        <div class="h-full px-6 flex items-center justify-between">
            <!-- Logo (Always Visible) -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('logo.svg') }}" alt="Logo" class="w-8 h-8">
                <div>
                    <h1 class="text-base font-bold text-primary">Courier Savings Bank</h1>
                    <p class="text-xs text-gray-500">Banking made simple</p>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="lg:hidden bg-gray-100 p-2 rounded-lg hover:bg-gray-200">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- User Profile Dropdown -->
            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                    <x-icons name="alert-circle" class="w-5 h-5" />
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Profile -->
                <div class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 rounded-lg px-3 py-2" onclick="document.getElementById('profileDropdown').classList.toggle('hidden')">
                    <div class="w-9 h-9 bg-gradient-to-br from-[#6B2D9E] to-[#5A2589] rounded-lg flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <!-- Dropdown Menu -->
                <div id="profileDropdown" class="hidden absolute top-14 right-6 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2">
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">
                        <x-icons name="users" class="w-4 h-4" />
                        My Profile
                    </a>
                    <div class="border-t border-gray-200 my-2"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                            <x-icons name="log-out" class="w-4 h-4" />
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex h-screen pt-16">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 top-16 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out w-64 bg-white border-r border-gray-200 flex flex-col shadow-sm z-40">
            
            <!-- Logo (Mobile Only - shown when sidebar is open) -->
            <div class="lg:hidden p-4 border-b border-gray-200 flex items-center gap-2">
                <img src="{{ asset('logo.svg') }}" alt="Logo" class="w-8 h-8">
                <div>
                    <h1 class="text-base font-bold text-primary">Courier Savings Bank</h1>
                    <p class="text-xs text-gray-500">Banking made simple</p>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto pt-3">
                @if(Auth::user()->is_admin)
                    <!-- Admin Menu -->
                    <p class="px-3 text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">Admin Control Panel</p>
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="bar-chart" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.users') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="users" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Manage Users</span>
                    </a>
                    
                    <a href="{{ route('admin.users.create') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.users.create') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="user-plus" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Create user</span>
                    </a>
                    
                    <a href="{{ route('admin.users') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition group">
                        <x-icons name="alert-triangle" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Tax & IRS Controls</span>
                    </a>
                    
                    <a href="{{ route('transactions.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('transactions.index') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="file-text" class="w-4 h-4" />
                        <span class="font-semibold text-sm">All Transactions</span>
                    </a>
                    
                    <div class="pt-3 mt-3 border-t border-gray-200">
                        <p class="px-3 text-xs font-bold text-gray-500 uppercase mb-2 tracking-wider">System</p>
                        
                        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition group">
                            <x-icons name="settings" class="w-4 h-4" />
                            <span class="font-semibold text-sm">Settings</span>
                        </a>
                        
                        <a href="#" class="flex items-center space-x-2 px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition group">
                            <x-icons name="shield-check" class="w-4 h-4" />
                            <span class="font-semibold text-sm">Security Logs</span>
                        </a>
                    </div>
                @else
                    <!-- Customer Menu -->
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="home" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('send-money') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('send-money') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="dollar-sign" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Send Money</span>
                    </a>
                    
                    <a href="{{ route('deposit') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('deposit') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="arrow-right" class="w-4 h-4 transform rotate-180" />
                        <span class="font-semibold text-sm">Deposit</span>
                    </a>
                    
                    <a href="{{ route('withdraw') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('withdraw') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="arrow-right" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Withdraw</span>
                    </a>
                    
                    <a href="{{ route('transactions.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('transactions.index') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="file-text" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Transactions</span>
                    </a>
                    
                    <a href="{{ route('statements.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('statements.*') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="download" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Statements</span>
                    </a>
                    
                    <a href="{{ route('beneficiaries.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('beneficiaries.*') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="users" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Beneficiaries</span>
                    </a>
                    
                    <a href="{{ route('recurring-transfers.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('recurring-transfers.*') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="clock" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Recurring</span>
                    </a>
                    
                    <a href="{{ route('bills.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('bills.*') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="receipt" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Bill Payments</span>
                    </a>
                    
                    <a href="{{ route('cards.index') }}" class="flex items-center space-x-2 px-3 py-2 rounded-lg {{ request()->routeIs('cards.*') ? 'bg-gradient-to-r from-[#6B2D9E] to-[#7B3FA8] text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }} transition group">
                        <x-icons name="credit-card" class="w-4 h-4" />
                        <span class="font-semibold text-sm">Virtual Cards</span>
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-8 lg:p-8 pt-20 lg:pt-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg flex items-start shadow-sm">
                        <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                            <x-icons name="check" class="w-3 h-3 text-white" />
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-sm mb-0.5">Success</p>
                            <p class="text-xs">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-lg flex items-start shadow-sm">
                        <div class="w-5 h-5 bg-red-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0 mt-0.5">
                            <x-icons name="alert-circle" class="w-3 h-3 text-white" />
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-sm mb-0.5">Error</p>
                            <p class="text-xs">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        mobileMenuButton?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</body>
</html>
