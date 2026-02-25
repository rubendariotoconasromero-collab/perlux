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
        Schema::create('OrderDetails', function (Blueprint $table) {
            $table->id('OrderDetailID');
            $table->unsignedBigInteger('OrderID');
            $table->unsignedBigInteger('ProductID');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->unsignedBigInteger('SizeID')->nullable();
            $table->string('product_name'); // Guardar nombre del producto en el momento de la compra
            $table->json('product_snapshot')->nullable(); // Snapshot completo del producto
            
            $table->timestamps();
            
            $table->foreign('OrderID')->references('OrderID')->on('Orders')->onDelete('cascade');
            $table->foreign('ProductID')->references('ProductID')->on('Products');
            $table->foreign('SizeID')->references('SizeID')->on('Sizes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OrderDetails');
    }
};
