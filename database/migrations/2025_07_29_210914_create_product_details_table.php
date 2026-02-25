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
        Schema::create('ProductDetails', function (Blueprint $table) {
            $table->id('DetailID');
            $table->unsignedBigInteger('ProductID');
            $table->string('DetailName', 100); // e.g., "Material", "Care Instructions"
            $table->string('DetailValue', 500); // e.g., "Cotton", "Machine washable"
            $table->timestamps();
            $table->foreign('ProductID')->references('ProductID')->on('Products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductDetails');
    }
};
