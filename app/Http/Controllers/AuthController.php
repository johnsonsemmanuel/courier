<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'user_id' => $this->generateUserId(),
        ]);

        // Create account for user
        Account::create([
            'user_id' => $user->id,
            'account_number' => $this->generateAccountNumber(),
            'account_name' => $validated['name'] . ' - Savings Account',
            'account_type' => 'savings',
            'balance' => 0,
            'status' => 'active',
        ]);

        Auth::login($user);
        
        return redirect()->route('dashboard')->with('success', 'Account created successfully. Welcome!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    private function generateAccountNumber()
    {
        // Generate a standard 10-digit bank account number
        // Format: 1234567890
        do {
            $accountNumber = str_pad(rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (Account::where('account_number', $accountNumber)->exists());
        
        return $accountNumber;
    }

    private function generateUserId()
    {
        // Generate a unique 8-digit user ID
        // Format: USR12345
        do {
            $userId = 'USR' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (User::where('user_id', $userId)->exists());
        
        return $userId;
    }
}
