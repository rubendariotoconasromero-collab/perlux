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
        Schema::create('Products', function (Blueprint $table) {
            $table->id('ProductID');
            $table->unsignedBigInteger('CollectionID')->nullable();
            $table->string('Name', 100);
            $table->string('Description', 500)->nullable();
            $table->decimal('Price', 10, 2);
            $table->integer('StockQuantity')->default(0);
            $table->boolean('IsFeatured')->default(false);
            $table->string('Fabric', 100)->nullable();
            $table->string('ReturnPolicy', 500)->nullable();
            $table->timestamps();
            $table->foreign('CollectionID')->references('CollectionID')->on('Collections')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Products');
    }
};
