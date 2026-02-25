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
        Schema::create('ProductSettings', function (Blueprint $table) {
            $table->id('SettingID');
            $table->unsignedBigInteger('ProductID');
            $table->string('SettingName', 100); // e.g., "Fit Type"
            $table->string('SettingValue', 100); // e.g., "Slim", "Regular"
            $table->timestamps();
            $table->foreign('ProductID')->references('ProductID')->on('Products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductSettings');
    }
};
