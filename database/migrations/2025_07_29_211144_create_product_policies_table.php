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
        Schema::create('ProductPolicies', function (Blueprint $table) {
            $table->id('PolicyID');
            $table->unsignedBigInteger('ProductID');
            $table->string('PolicyName', 100); // e.g., "Return Policy", "Shipping Policy"
            $table->string('PolicyValue', 500); // e.g., "30-day return", "Free shipping"
            $table->timestamps();
            $table->foreign('ProductID')->references('ProductID')->on('Products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductPolicies');
    }
};
