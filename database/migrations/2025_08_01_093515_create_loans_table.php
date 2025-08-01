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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Borrower (student)
            $table->foreignId('catalogue_id')->constrained('catalogues')->onDelete('cascade'); // The borrowed book
            $table->timestamp('borrowed_at')->useCurrent(); // When the book was borrowed
            $table->timestamp('due_date')->nullable(); // When the book is due for return
            $table->timestamp('returned_at')->nullable(); // When the book was actually returned (null if not yet returned)
            $table->enum('status', ['borrowed', 'returned', 'overdue'])->default('borrowed'); // Current status of the loan
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
