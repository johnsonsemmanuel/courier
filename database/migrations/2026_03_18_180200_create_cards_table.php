<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->string('card_number')->unique();
            $table->string('card_holder_name');
            $table->string('cvv');
            $table->string('expiry_month');
            $table->string('expiry_year');
            $table->string('card_type')->default('virtual'); // virtual, physical
            $table->string('card_brand')->default('visa'); // visa, mastercard
            $table->string('status')->default('active'); // active, frozen, cancelled
            $table->decimal('daily_limit', 15, 2)->default(5000.00);
            $table->decimal('monthly_limit', 15, 2)->default(50000.00);
            $table->decimal('daily_spent', 15, 2)->default(0.00);
            $table->decimal('monthly_spent', 15, 2)->default(0.00);
            $table->timestamp('last_reset_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
