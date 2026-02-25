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
        Schema::create('Collections', function (Blueprint $table) {
            $table->id('CollectionID');
            $table->string('CollectionName', 100);
            $table->string('Description', 500)->nullable();
            $table->date('LaunchDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Collections');
    }
};
