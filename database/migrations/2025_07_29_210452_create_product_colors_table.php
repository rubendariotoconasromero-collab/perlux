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
        Schema::create('ProductColors', function (Blueprint $table) {
            $table->id('ProductColorID');
            $table->unsignedBigInteger('ProductID');
            $table->unsignedBigInteger('ColorID');
            $table->timestamps();
            $table->foreign('ProductID')->references('ProductID')->on('Products')->onDelete('cascade');
            $table->foreign('ColorID')->references('ColorID')->on('Colors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductColors');
    }
};
