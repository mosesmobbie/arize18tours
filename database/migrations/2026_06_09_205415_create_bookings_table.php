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
            $table->id();
            $table->string('service_type');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('pickup_address');
            $table->string('dropoff_address')->nullable();
            $table->string('pickup_time');
            $table->string('dropoff_time')->nullable();
            $table->integer('passengers')->default(0);
            $table->string('transmission')->nullable();
            $table->string('flight_number')->nullable();
            $table->string('id_number')->nullable();
            $table->string('reservation_number')->nullable();
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->integer('user_id')->default(0);
            $table->timestamps();
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
