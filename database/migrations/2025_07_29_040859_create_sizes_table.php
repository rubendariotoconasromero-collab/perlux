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
        Schema::create('Sizes', function (Blueprint $table) {
            $table->id('SizeID');
            $table->string('SizeName', 10);
            $table->decimal('Bust', 5, 2)->nullable();
            $table->decimal('Waist', 5, 2)->nullable();
            $table->decimal('Hips', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Sizes');
    }
};
