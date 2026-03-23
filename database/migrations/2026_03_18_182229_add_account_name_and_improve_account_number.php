<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('account_name')->after('account_number')->nullable();
            $table->string('status')->after('is_active')->default('active'); // active, frozen, suspended
            $table->decimal('withheld_amount', 15, 2)->after('balance')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['account_name', 'status', 'withheld_amount']);
        });
    }
};
