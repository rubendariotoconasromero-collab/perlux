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
        Schema::create('product_certificates', function (Blueprint $table) {
            $table->id();
            // Identificador único del certificado
            $table->string('code')->unique();
            // Relación con el detalle del pedido (Asegúrate de que el tipo coincida con tu PK de OrderDetail)
            $table->unsignedBigInteger('order_detail_id'); 
            
            // Asumiendo que tu tabla de detalles se llama 'order_details' y su PK es 'OrderDetailID'
            $table->foreign('order_detail_id')
                  ->references('OrderDetailID')
                  ->on('OrderDetails')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_certificates');
    }
};
