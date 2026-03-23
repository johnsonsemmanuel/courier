<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\TaxAlert;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Normal User - No Issues
        $user1 = User::create([
            'user_id' => 'USR10001',
            'name' => 'John Doe',
            'email' => 'demo@bankapp.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Main Street, New York, NY 10001',
            'is_admin' => false,
        ]);
        $user1->update(['email_verified_at' => now()]);

        $account1 = Account::create([
            'user_id' => $user1->id,
            'account_number' => '1234567890',
            'account_name' => 'John Doe Savings',
            'account_type' => 'savings',
            'balance' => 5000.00,
            'status' => 'active',
        ]);

        Transaction::create([
            'account_id' => $account1->id,
            'transaction_type' => 'deposit',
            'amount' => 5000.00,
            'description' => 'Initial deposit',
            'status' => 'completed',
            'reference_number' => 'TXN' . strtoupper(Str::random(12)),
        ]);

        // 2. User with IRS Tax Alert - Transactions Blocked
        $user2 = User::create([
            'user_id' => 'USR10002',
            'name' => 'Sarah Johnson',
            'email' => 'tax@bankapp.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 987-6543',
            'address' => '456 Oak Avenue, Los Angeles, CA 90001',
            'is_admin' => false,
        ]);
        $user2->update(['email_verified_at' => now()]);

        $account2 = Account::create([
            'user_id' => $user2->id,
            'account_number' => '2345678901',
            'account_name' => 'Sarah Johnson Checking',
            'account_type' => 'checking',
            'balance' => 3000.00,
            'status' => 'active',
        ]);

        TaxAlert::create([
            'user_id' => $user2->id,
            'has_tax_obligation' => true,
            'tax_amount' => 2500.00,
            'notes' => 'Pending IRS tax obligation from 2023. All transactions blocked until resolved.',
        ]);

        // 3. User with Frozen Account
        $user3 = User::create([
            'user_id' => 'USR10003',
            'name' => 'Michael Brown',
            'email' => 'frozen@bankapp.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 456-7890',
            'address' => '789 Pine Street, Chicago, IL 60601',
            'is_admin' => false,
        ]);
        $user3->update(['email_verified_at' => now()]);

        $account3 = Account::create([
            'user_id' => $user3->id,
            'account_number' => '3456789012',
            'account_name' => 'Michael Brown Savings',
            'account_type' => 'savings',
            'balance' => 8000.00,
            'status' => 'frozen',
        ]);

        // 4. User with Withheld Funds
        $user4 = User::create([
            'user_id' => 'USR10004',
            'name' => 'Emily Davis',
            'email' => 'withheld@bankapp.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 234-5678',
            'address' => '321 Elm Street, Houston, TX 77001',
            'is_admin' => false,
        ]);
        $user4->update(['email_verified_at' => now()]);

        $account4 = Account::create([
            'user_id' => $user4->id,
            'account_number' => '4567890123',
            'account_name' => 'Emily Davis Checking',
            'account_type' => 'checking',
            'balance' => 6000.00,
            'status' => 'active',
            'withheld_amount' => 1500.00,
        ]);

        // 5. User with Both Tax Alert and Withheld Funds
        $user5 = User::create([
            'user_id' => 'USR10005',
            'name' => 'Robert Wilson',
            'email' => 'complex@bankapp.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 345-6789',
            'address' => '654 Maple Avenue, Miami, FL 33101',
            'is_admin' => false,
        ]);
        $user5->update(['email_verified_at' => now()]);

        $account5 = Account::create([
            'user_id' => $user5->id,
            'account_number' => '5678901234',
            'account_name' => 'Robert Wilson Savings',
            'account_type' => 'savings',
            'balance' => 4500.00,
            'status' => 'active',
            'withheld_amount' => 2000.00,
        ]);

        TaxAlert::create([
            'user_id' => $user5->id,
            'has_tax_obligation' => true,
            'tax_amount' => 3500.00,
            'notes' => 'Multiple IRS tax obligations. Account under investigation.',
        ]);

        // 6. High Balance User - No Issues
        $user6 = User::create([
            'user_id' => 'USR10006',
            'name' => 'Jennifer Martinez',
            'email' => 'premium@bankapp.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 567-8901',
            'address' => '987 Cedar Lane, Boston, MA 02101',
            'is_admin' => false,
        ]);
        $user6->update(['email_verified_at' => now()]);

        $account6 = Account::create([
            'user_id' => $user6->id,
            'account_number' => '6789012345',
            'account_name' => 'Jennifer Martinez Premium',
            'account_type' => 'savings',
            'balance' => 25000.00,
            'status' => 'active',
        ]);

        Transaction::create([
            'account_id' => $account6->id,
            'transaction_type' => 'deposit',
            'amount' => 25000.00,
            'description' => 'Initial premium deposit',
            'status' => 'completed',
            'reference_number' => 'TXN' . strtoupper(Str::random(12)),
        ]);

        // 7. Admin User
        $admin = User::create([
            'user_id' => 'USR00001',
            'name' => 'Admin User',
            'email' => 'admin@bankapp.com',
            'password' => Hash::make('password'),
            'phone' => '+1 (555) 000-0000',
            'address' => '100 Admin Street, Washington, DC 20001',
            'is_admin' => true,
        ]);
        $admin->update(['email_verified_at' => now()]);

        Account::create([
            'user_id' => $admin->id,
            'account_number' => '0000000001',
            'account_name' => 'Admin Account',
            'account_type' => 'savings',
            'balance' => 100000.00,
            'status' => 'active',
        ]);
    }
}
