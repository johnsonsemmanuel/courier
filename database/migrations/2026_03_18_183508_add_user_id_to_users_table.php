<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Account;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_id')->unique()->after('id')->nullable();
        });

        // Generate user IDs for existing users
        $users = User::all();
        foreach ($users as $user) {
            $user->user_id = $this->generateUserId();
            $user->save();
        }

        // Update existing accounts to have numeric account numbers
        $accounts = Account::all();
        foreach ($accounts as $account) {
            if (!is_numeric($account->account_number)) {
                $account->account_number = $this->generateAccountNumber();
                $account->save();
            }
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

    private function generateUserId(): string
    {
        // Generate a unique 8-digit user ID
        do {
            $userId = 'USR' . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (User::where('user_id', $userId)->exists());
        
        return $userId;
    }

    private function generateAccountNumber(): string
    {
        // Generate a standard 10-digit bank account number
        do {
            $accountNumber = str_pad(rand(1000000000, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (Account::where('account_number', $accountNumber)->exists());
        
        return $accountNumber;
    }
};
