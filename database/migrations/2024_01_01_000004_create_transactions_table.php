<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->string('transaction_type'); // deposit, withdrawal, transfer, bill_payment
            $table->decimal('amount', 15, 2);
            $table->string('recipient_account')->nullable();
            $table->string('recipient_name')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('reference_number')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
