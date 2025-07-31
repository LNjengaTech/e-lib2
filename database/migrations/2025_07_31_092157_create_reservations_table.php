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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to the users table
            $table->foreignId('catalogue_id')->constrained('catalogues')->onDelete('cascade'); // Links to the catalogue table
            $table->timestamp('reserved_at')->useCurrent(); // When the reservation was made
            $table->timestamp('expires_at')->nullable(); // When the reservation expires (e.g., 24 hours later)
            $table->enum('status', ['pending', 'confirmed_pickup', 'cancelled', 'expired'])->default('pending'); // Current status of the reservation
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
