@extends('layouts.dashboard')

@section('title', 'Create user account - Admin')

@section('content')
<div class="flex justify-between items-start mb-5">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Create user account</h1>
        <p class="text-gray-600 mt-1 text-xs">Provision a new customer account (user record + savings account).</p>
    </div>
    <a href="{{ route('admin.users') }}" class="text-xs text-primary font-semibold hover:text-primary-dark">← Back to users</a>
</div>

@if ($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-xs">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold text-gray-700 mb-1">Full name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10">
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10">
        </div>

        <div>
            <label for="phone" class="block text-xs font-semibold text-gray-700 mb-1">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                   class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10">
        </div>

        <div>
            <label for="address" class="block text-xs font-semibold text-gray-700 mb-1">Address</label>
            <textarea name="address" id="address" rows="2" required
                      class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10 resize-none">{{ old('address') }}</textarea>
        </div>

        <div class="border-t border-gray-100 pt-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="auto_generate_password" value="1" id="auto_generate_password"
                       class="rounded border-gray-300 text-primary focus:ring-primary"
                       {{ old('auto_generate_password') ? 'checked' : '' }}>
                <span class="text-xs font-semibold text-gray-800">Generate a secure random password</span>
            </label>
            <p class="text-xs text-gray-500 mt-1 ml-6">If unchecked, you must set and confirm the password below.</p>
        </div>

        <div id="password-fields" class="space-y-3">
            <div>
                <label for="password" class="block text-xs font-semibold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password"
                       class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">Confirm password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>
        </div>

        <div>
            <label for="initial_balance" class="block text-xs font-semibold text-gray-700 mb-1">Opening balance (optional)</label>
            <input type="number" name="initial_balance" id="initial_balance" step="0.01" min="0" value="{{ old('initial_balance', '0') }}"
                   class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-primary focus:ring-4 focus:ring-primary/10">
        </div>

        <div class="space-y-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="send_welcome_email" value="0">
                <input type="checkbox" name="send_welcome_email" value="1" id="send_welcome_email"
                       class="rounded border-gray-300 text-primary focus:ring-primary"
                       @checked(old('send_welcome_email', '1') === '1')>
                <span class="text-xs text-gray-800">Email login instructions to the user (requires working SMTP)</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_admin" value="0">
                <input type="checkbox" name="is_admin" value="1" id="is_admin"
                       class="rounded border-gray-300 text-primary focus:ring-primary"
                       @checked(old('is_admin', '0') === '1')>
                <span class="text-xs text-gray-800">Grant admin privileges</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full sm:w-auto bg-primary hover:bg-primary-dark text-white font-semibold py-2.5 px-6 rounded-lg text-sm shadow-lg">
                Create account
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const auto = document.getElementById('auto_generate_password');
    const pwdFields = document.getElementById('password-fields');
    const pwdInputs = pwdFields.querySelectorAll('input');
    function toggle() {
        const on = auto && auto.checked;
        pwdFields.style.opacity = on ? '0.5' : '1';
        pwdFields.style.pointerEvents = on ? 'none' : 'auto';
        pwdInputs.forEach(function (i) {
            if (on) { i.value = ''; i.removeAttribute('required'); }
            else { i.setAttribute('required', 'required'); }
        });
    }
    if (auto) {
        auto.addEventListener('change', toggle);
        toggle();
    }
});
</script>
@endsection
