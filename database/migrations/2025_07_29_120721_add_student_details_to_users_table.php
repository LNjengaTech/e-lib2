<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add reg_number column, make it unique and nullable for non-student users initially
            $table->string('reg_number')->unique()->nullable()->after('utype'); // Placed after 'utype'
            // Add fee_balance column, default to 0.00
            $table->decimal('fee_balance', 8, 2)->default(0.00)->after('reg_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the columns if the migration is rolled back
            $table->dropColumn('fee_balance');
            $table->dropColumn('reg_number');
        });
    }
};
