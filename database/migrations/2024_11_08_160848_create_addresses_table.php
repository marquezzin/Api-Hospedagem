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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained('guests');
            $table->string('zipcode',9); //CEP -> Máx 9 caracteres
            $table->string('city');
            $table->string('state');
            $table->string('street'); //Rua / Logradouro
            $table->string('district'); //bairro
            $table->string('number');
            $table->string('complement')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
