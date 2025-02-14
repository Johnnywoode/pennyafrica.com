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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('type'); // Type of notification (e.g., "Reminder", "Announcement", etc.)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');; // ID of the recipient (nullable for broadcast notifications)
            $table->text('message'); // Main content of the notification
            $table->json('data')->nullable(); // Additional payload data for dynamic notifications
            $table->boolean('is_read')->default(false); // Read status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
