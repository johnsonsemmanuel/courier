@extends('layouts.dashboard')

@section('title', 'Manage Users - Courier Savings Bank')

@section('content')
@if (session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl text-xs font-medium">
        {{ session('success') }}
    </div>
@endif
@if (session('warning'))
    <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-900 px-4 py-3 rounded-xl text-xs font-medium">
        {{ session('warning') }}
    </div>
@endif

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manage Users</h1>
        <p class="text-gray-600 mt-1 text-xs">View and manage all user accounts</p>
    </div>
    <div class="flex flex-col items-stretch sm:items-end gap-2">
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold py-2 px-4 rounded-lg text-xs shadow-lg transition">
            <x-icons name="user-plus" class="w-4 h-4" />
            Create user account
        </a>
        <div class="text-right">
            <p class="text-xs text-gray-500">{{ now()->format('l') }}</p>
            <p class="text-xs font-semibold text-gray-900">{{ now()->format('F d, Y') }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Name</th>
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Email</th>
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Account</th>
                    <th class="text-left py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Balance</th>
                    <th class="text-center py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Tax Alert</th>
                    <th class="text-center py-3 px-3 text-xs font-bold text-gray-700 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-3 px-3">
                            <div>
                                <p class="font-bold text-gray-900 text-xs">{{ $user->name }}</p>
                                @if($user->is_admin)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-primary mt-0.5">
                                        Admin
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-3 text-gray-700 text-xs">{{ $user->email }}</td>
                        <td class="py-3 px-3 text-gray-700 font-mono text-xs">
                            {{ $user->accounts->first()->account_number ?? 'N/A' }}
                        </td>
                        <td class="py-3 px-3 font-bold text-gray-900 text-xs">
                            ${{ number_format($user->accounts->first()->balance ?? 0, 2) }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if($user->taxAlert && $user->taxAlert->has_tax_obligation)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                    <x-icons name="alert-triangle" class="w-3 h-3 mr-1" />
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    <x-icons name="check" class="w-3 h-3 mr-1" />
                                    Clear
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openTaxModal({{ $user->id }}, '{{ $user->name }}', {{ $user->taxAlert ? ($user->taxAlert->has_tax_obligation ? 'true' : 'false') : 'false' }}, {{ $user->taxAlert ? $user->taxAlert->tax_amount : 0 }})"
                                        class="text-primary hover:text-primary-dark font-bold transition text-xs px-2 py-1 bg-purple-50 rounded">
                                    Tax
                                </button>
                                <button onclick="openAccountModal({{ $user->id }}, '{{ $user->name }}', {{ $user->accounts->first()->balance ?? 0 }}, {{ $user->accounts->first()->withheld_amount ?? 0 }}, '{{ $user->accounts->first()->status ?? 'active' }}')"
                                        class="text-blue-600 hover:text-blue-800 font-bold transition text-xs px-2 py-1 bg-blue-50 rounded">
                                    Account
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $users->links() }}
    </div>
</div>

<!-- Tax Alert Modal -->
<div id="taxModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-2xl">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-900">Manage Tax Alert</h3>
            <button onclick="closeTaxModal()" class="text-gray-400 hover:text-gray-600 transition">
                <x-icons name="x" class="w-5 h-5" />
            </button>
        </div>
        <p class="text-gray-600 mb-5 text-xs">Update tax obligation status for <span id="userName" class="font-bold text-gray-900"></span></p>
        
        <form id="taxForm" method="POST" class="space-y-4">
            @csrf
            
            <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4 mb-4">
                <label class="flex items-start space-x-3 cursor-pointer">
                    <input type="checkbox" name="has_tax_obligation" id="hasTaxObligation" value="1" 
                           class="w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300 rounded mt-0.5">
                    <div class="flex-1">
                        <span class="text-gray-900 font-bold text-sm block mb-1">Block All Transactions</span>
                        <p class="text-xs text-gray-600">User has pending tax obligations with the IRS. All transactions will be blocked until resolved. User must contact customer support.</p>
                    </div>
                </label>
            </div>

            <div>
                <label for="tax_amount" class="block text-gray-700 font-semibold mb-2 text-xs">Tax Amount Owed</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold text-xs">$</span>
                    <input type="number" name="tax_amount" id="tax_amount" step="0.01" min="0"
                           class="w-full pl-8 pr-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                           placeholder="0.00">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-gray-700 font-semibold mb-2 text-xs">Admin Notes</label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none text-xs"
                          placeholder="Add notes about the tax obligation (e.g., case number, contact details, resolution steps)"></textarea>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <div class="flex gap-2">
                    <x-icons name="alert-triangle" class="w-4 h-4 text-yellow-600 flex-shrink-0 mt-0.5" />
                    <p class="text-xs text-yellow-800">
                        <strong>Important:</strong> When "Block All Transactions" is enabled, the user will see: "You have pending tax obligations with the IRS. Please contact customer support before proceeding."
                    </p>
                </div>
            </div>

            <div class="flex space-x-3 mt-5">
                <button type="submit" class="flex-1 bg-primary hover:bg-primary-dark text-white font-bold py-2.5 px-5 rounded-lg transition shadow-lg text-xs">
                    Update Tax Alert
                </button>
                <button type="button" onclick="closeTaxModal()" class="px-5 py-2.5 border-2 border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition text-xs">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Account Management Modal -->
<div id="accountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl p-6 max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-bold text-gray-900">Account Management</h3>
            <button onclick="closeAccountModal()" class="text-gray-400 hover:text-gray-600 transition">
                <x-icons name="x" class="w-5 h-5" />
            </button>
        </div>
        <p class="text-gray-600 mb-5 text-xs">Manage account for <span id="accountUserName" class="font-bold text-gray-900"></span></p>
        
        <!-- Account Info -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                <p class="text-xs text-green-600 font-semibold mb-1">Available Balance</p>
                <p class="text-lg font-bold text-green-700">$<span id="accountBalance">0.00</span></p>
            </div>
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                <p class="text-xs text-orange-600 font-semibold mb-1">Withheld Funds</p>
                <p class="text-lg font-bold text-orange-700">$<span id="withheldAmount">0.00</span></p>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="text-xs text-blue-600 font-semibold mb-1">Account Status</p>
                <p class="text-sm font-bold text-blue-700"><span id="accountStatus">Active</span></p>
            </div>
        </div>

        <!-- Action Tabs -->
        <div class="border-b border-gray-200 mb-4">
            <div class="flex gap-2">
                <button onclick="showTab('addFunds')" id="tab-addFunds" class="px-4 py-2 text-xs font-semibold border-b-2 border-purple-600 text-purple-600">
                    Add Funds
                </button>
                <button onclick="showTab('withholdFunds')" id="tab-withholdFunds" class="px-4 py-2 text-xs font-semibold border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                    Withhold Funds
                </button>
                <button onclick="showTab('releaseFunds')" id="tab-releaseFunds" class="px-4 py-2 text-xs font-semibold border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                    Release Funds
                </button>
                <button onclick="showTab('freezeAccount')" id="tab-freezeAccount" class="px-4 py-2 text-xs font-semibold border-b-2 border-transparent text-gray-600 hover:text-gray-900">
                    Freeze/Unfreeze
                </button>
            </div>
        </div>

        <!-- Add Funds Form -->
        <div id="form-addFunds" class="tab-content">
            <form id="addFundsForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Amount to Add</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold text-xs">$</span>
                        <input type="number" name="amount" step="0.01" min="1" required
                               class="w-full pl-8 pr-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                               placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Notes</label>
                    <textarea name="notes" rows="2"
                              class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none text-xs"
                              placeholder="Reason for adding funds"></textarea>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg transition shadow-lg text-xs">
                    Add Funds
                </button>
            </form>
        </div>

        <!-- Withhold Funds Form -->
        <div id="form-withholdFunds" class="tab-content hidden">
            <form id="withholdFundsForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Amount to Withhold</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold text-xs">$</span>
                        <input type="number" name="amount" step="0.01" min="1" required
                               class="w-full pl-8 pr-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                               placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Reason</label>
                    <textarea name="reason" rows="2"
                              class="w-full px-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition resize-none text-xs"
                              placeholder="Reason for withholding funds"></textarea>
                </div>
                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 px-5 rounded-lg transition shadow-lg text-xs">
                    Withhold Funds
                </button>
            </form>
        </div>

        <!-- Release Funds Form -->
        <div id="form-releaseFunds" class="tab-content hidden">
            <form id="releaseFundsForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 font-semibold mb-2 text-xs">Amount to Release</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-bold text-xs">$</span>
                        <input type="number" name="amount" step="0.01" min="1" required
                               class="w-full pl-8 pr-3 py-2.5 border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 transition text-xs"
                               placeholder="0.00">
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-lg transition shadow-lg text-xs">
                    Release Funds
                </button>
            </form>
        </div>

        <!-- Freeze/Unfreeze Account -->
        <div id="form-freezeAccount" class="tab-content hidden">
            <div class="space-y-4">
                <p class="text-xs text-gray-600">Current Status: <span id="currentStatus" class="font-bold"></span></p>
                <form id="freezeForm" method="POST">
                    @csrf
                    <button type="submit" id="freezeButton" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-lg transition shadow-lg text-xs">
                        Freeze Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let currentUserId = null;

function openTaxModal(userId, userName, hasTax, taxAmount) {
    document.getElementById('taxModal').classList.remove('hidden');
    document.getElementById('userName').textContent = userName;
    document.getElementById('taxForm').action = `/admin/users/${userId}/tax-alert`;
    document.getElementById('hasTaxObligation').checked = hasTax;
    document.getElementById('tax_amount').value = taxAmount || '';
}

function closeTaxModal() {
    document.getElementById('taxModal').classList.add('hidden');
}

function openAccountModal(userId, userName, balance, withheld, status) {
    currentUserId = userId;
    document.getElementById('accountModal').classList.remove('hidden');
    document.getElementById('accountUserName').textContent = userName;
    document.getElementById('accountBalance').textContent = parseFloat(balance).toFixed(2);
    document.getElementById('withheldAmount').textContent = parseFloat(withheld).toFixed(2);
    document.getElementById('accountStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
    document.getElementById('currentStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);
    
    // Update form actions
    document.getElementById('addFundsForm').action = `/admin/users/${userId}/add-funds`;
    document.getElementById('withholdFundsForm').action = `/admin/users/${userId}/withhold-funds`;
    document.getElementById('releaseFundsForm').action = `/admin/users/${userId}/release-funds`;
    
    // Update freeze button
    const freezeButton = document.getElementById('freezeButton');
    const freezeForm = document.getElementById('freezeForm');
    if (status === 'frozen') {
        freezeButton.textContent = 'Unfreeze Account';
        freezeButton.classList.remove('bg-red-600', 'hover:bg-red-700');
        freezeButton.classList.add('bg-green-600', 'hover:bg-green-700');
        freezeForm.action = `/admin/users/${userId}/unfreeze`;
    } else {
        freezeButton.textContent = 'Freeze Account';
        freezeButton.classList.remove('bg-green-600', 'hover:bg-green-700');
        freezeButton.classList.add('bg-red-600', 'hover:bg-red-700');
        freezeForm.action = `/admin/users/${userId}/freeze`;
    }
    
    showTab('addFunds');
}

function closeAccountModal() {
    document.getElementById('accountModal').classList.add('hidden');
}

function showTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active state from all tab buttons
    document.querySelectorAll('[id^="tab-"]').forEach(btn => {
        btn.classList.remove('border-purple-600', 'text-purple-600');
        btn.classList.add('border-transparent', 'text-gray-600');
    });
    
    // Show selected tab
    document.getElementById('form-' + tabName).classList.remove('hidden');
    
    // Add active state to selected tab button
    const activeBtn = document.getElementById('tab-' + tabName);
    activeBtn.classList.add('border-purple-600', 'text-purple-600');
    activeBtn.classList.remove('border-transparent', 'text-gray-600');
}

// Close modals on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTaxModal();
        closeAccountModal();
    }
});
</script>
@endsection
