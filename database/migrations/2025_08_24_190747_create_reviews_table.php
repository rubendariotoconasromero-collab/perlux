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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();  // ID único de la review
            $table->unsignedBigInteger('user_id');  // FK a users.id (el usuario que califica)
            $table->unsignedBigInteger('product_id');  // FK a Products.ProductID (el producto calificado)
            $table->integer('rating')->between(1, 5);  // Puntuación de 1 a 5 estrellas
            $table->text('comment')->nullable();  // Comentario opcional
            $table->string('title')->nullable();  // Título de la review (como "Práctico y amigable")
            $table->string('age_range')->nullable();  // Rango de edad (e.g., '18-24')
            $table->string('size')->nullable();  // Talla usada (e.g., 'S')
            $table->timestamps();  // created_at y updated_at para fecha y hora

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  // Si se borra usuario, borra reviews
            $table->foreign('product_id')->references('ProductID')->on('Products')->onDelete('cascade');  // Si se borra producto, borra reviews
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
