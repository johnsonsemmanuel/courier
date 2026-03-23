<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <img src="{{ asset('logo.svg') }}" alt="Logo" class="w-8 h-8">
                    <span class="text-base font-bold">Courier Savings Bank</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Modern banking for everyone, everywhere.
                </p>
            </div>
            
            <div>
                <h6 class="font-bold mb-3 text-sm">Products</h6>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('pages.personal') }}" class="hover:text-white transition">Personal Banking</a></li>
                    <li><a href="{{ route('pages.business') }}" class="hover:text-white transition">Business Banking</a></li>
                    <li><a href="{{ route('pages.loans') }}" class="hover:text-white transition">Loans</a></li>
                    <li><a href="{{ route('pages.investments') }}" class="hover:text-white transition">Investments</a></li>
                </ul>
            </div>
            
            <div>
                <h6 class="font-bold mb-3 text-sm">Company</h6>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('pages.about') }}" class="hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('pages.contact') }}" class="hover:text-white transition">Contact</a></li>
                    <li><a href="{{ route('pages.support') }}" class="hover:text-white transition">Support</a></li>
                </ul>
            </div>
            
            <div>
                <h6 class="font-bold mb-3 text-sm">Legal</h6>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('pages.privacy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="{{ route('pages.terms') }}" class="hover:text-white transition">Terms of Service</a></li>
                    <li><a href="#" class="hover:text-white transition">Security</a></li>
                    <li><a href="#" class="hover:text-white transition">FDIC Insurance</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 pt-6 text-center text-sm text-gray-400">
            <p>&copy; {{ date('Y') }} Courier Savings Bank. All rights reserved. Member FDIC.</p>
        </div>
    </div>
</footer>
