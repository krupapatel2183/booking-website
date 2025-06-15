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
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('booking_date')->nullable();
            $table->enum('type', ['Full Day', 'Half Day', 'Custom'])->nullable();
            $table->enum('slot', ['First Half', 'Second Half'])->nullable();
            $table->timestamp('booking_from')->nullable();
            $table->timestamp('booking_to')->nullable();
            
            // Add user_id column (assuming UUID on users.id)
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
