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
        Schema::create('ProductVariants', function (Blueprint $table) {
            $table->id('VariantID');
            $table->unsignedBigInteger('ProductID');
            $table->unsignedBigInteger('SizeID');
            $table->unsignedBigInteger('ColorID');
            $table->integer('StockQuantity')->default(0);
            $table->decimal('Price', 10, 2)->nullable(); // Precio específico por variante (opcional)
            $table->string('SKU')->nullable(); // Código único para la variante
            $table->timestamps();
            
            // Claves foráneas
            $table->foreign('ProductID')->references('ProductID')->on('Products')->onDelete('cascade');
            $table->foreign('SizeID')->references('SizeID')->on('Sizes')->onDelete('cascade');
            $table->foreign('ColorID')->references('ColorID')->on('Colors')->onDelete('cascade');
            
            // Índice único para evitar duplicados
            $table->unique(['ProductID', 'SizeID', 'ColorID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductVariants');
    }
};
