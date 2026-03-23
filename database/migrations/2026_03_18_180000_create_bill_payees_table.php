<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill_payees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('payee_name');
            $table->string('payee_type'); // utility, telecom, subscription, insurance, etc.
            $table->string('account_number');
            $table->string('provider'); // e.g., "Electric Company", "Water Board", "MTN", "Netflix"
            $table->string('nickname')->nullable();
            $table->boolean('is_favorite')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_payees');
    }
};
