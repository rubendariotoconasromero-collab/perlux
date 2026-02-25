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
        Schema::create('Orders', function (Blueprint $table) {
            $table->id('OrderID');
            $table->unsignedBigInteger('user_id')->nullable(); // Si tienes autenticación
            $table->string('external_reference')->unique();
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->default('pending'); // pending, approved, rejected, cancelled
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 3)->default('PEN');
            $table->json('payer_info')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();
            
            // Si usas autenticación de usuarios
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Orders');
    }
};
