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
        // Add English description to destinasi table
        Schema::table('destinasi', function (Blueprint $table) {
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
        });

        // Add English description to wilayah table
        Schema::table('wilayah', function (Blueprint $table) {
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            $table->dropColumn('deskripsi_en');
        });

        Schema::table('wilayah', function (Blueprint $table) {
            $table->dropColumn('deskripsi_en');
        });
    }
};
