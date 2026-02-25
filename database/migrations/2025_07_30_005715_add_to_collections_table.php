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
        Schema::table('Collections', function (Blueprint $table) {
            //
            $table->string('Image', 255)->nullable()->after('Description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Collections', function (Blueprint $table) {
            $table->dropColumn('Image');
        });
    }
};
