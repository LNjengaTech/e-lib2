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
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The student who incurred the fine
            $table->foreignId('loan_id')->nullable()->constrained('loans')->onDelete('set null'); // The specific loan this fine is related to (nullable)
            $table->decimal('amount', 8, 2); // The fine amount, e.g., 999999.99
            $table->string('reason'); // Description of the fine (e.g., "Overdue book", "Damaged book")
            $table->timestamp('issued_at')->useCurrent(); // When the fine was issued
            $table->timestamp('paid_at')->nullable(); // When the fine was paid (null if outstanding)
            $table->enum('status', ['outstanding', 'paid', 'waived'])->default('outstanding'); // Current status of the fine
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
