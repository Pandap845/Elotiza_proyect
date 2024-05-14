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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
            $table->foreignId('elote_id')->constrained()->onDelete('cascade');
            $table->foreignId('topping_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2); // Precio podría ser el precio por unidad del elote
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};
