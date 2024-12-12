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
        Schema::create('guest_reservation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('guests');
            $table->foreignId('reservation_id')->constrained('reservations');
            $table->string('type'); //titular que fez a reserva
            $table->dateTime('checkin_at')->nullable(); //data de entrada
            $table->dateTime('checkout_at')->nullable(); //data de saida
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_reservation');
    }
};
