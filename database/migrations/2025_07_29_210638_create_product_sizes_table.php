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
        Schema::create('ProductSizes', function (Blueprint $table) {
            $table->id('ProductSizeID');
            $table->unsignedBigInteger('ProductID');
            $table->unsignedBigInteger('SizeID');
            $table->timestamps();
            $table->foreign('ProductID')->references('ProductID')->on('Products')->onDelete('cascade');
            $table->foreign('SizeID')->references('SizeID')->on('Sizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductSizes');
    }
};
