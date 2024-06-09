<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  
     public function up():void
     {
         Schema::create('envio_pagos', function (Blueprint $table) {
             $table->id();
             $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
             $table->string('ciudad');
             $table->string('colonia');
             $table->string('calle');
             $table->string('numero_exterior');
             $table->string('numero_interior')->nullable();
             $table->string('paypal_id')->nullable(); // ID de la transacción PayPal
             $table->decimal('monto', 10, 2); // Monto cobrado
          
             $table->timestamps();
         });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_pagos');
    }
};
