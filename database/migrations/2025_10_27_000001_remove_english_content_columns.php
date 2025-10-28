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
        // Remove English content columns since we use Laravel translations for UI,
        // and admin panel (content entry) is Indonesian-only for internal staff
        
        if (Schema::hasColumn('destinasi', 'deskripsi_en')) {
            Schema::table('destinasi', function (Blueprint $table) {
                $table->dropColumn('deskripsi_en');
            });
        }
        
        if (Schema::hasColumn('wilayah', 'deskripsi_en')) {
            Schema::table('wilayah', function (Blueprint $table) {
                $table->dropColumn('deskripsi_en');
            });
        }
        
        if (Schema::hasColumn('akomodasi', 'deskripsi_en')) {
            Schema::table('akomodasi', function (Blueprint $table) {
                $table->dropColumn('deskripsi_en');
            });
        }
        
        if (Schema::hasColumn('transportasi', 'deskripsi_en')) {
            Schema::table('transportasi', function (Blueprint $table) {
                $table->dropColumn('deskripsi_en');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore English columns if rollback needed
        
        if (!Schema::hasColumn('destinasi', 'deskripsi_en')) {
            Schema::table('destinasi', function (Blueprint $table) {
                $table->text('deskripsi_en')->nullable()->after('deskripsi');
            });
        }
        
        if (!Schema::hasColumn('wilayah', 'deskripsi_en')) {
            Schema::table('wilayah', function (Blueprint $table) {
                $table->text('deskripsi_en')->nullable()->after('deskripsi');
            });
        }
        
        if (!Schema::hasColumn('akomodasi', 'deskripsi_en')) {
            Schema::table('akomodasi', function (Blueprint $table) {
                $table->text('deskripsi_en')->nullable()->after('deskripsi');
            });
        }
        
        if (!Schema::hasColumn('transportasi', 'deskripsi_en')) {
            Schema::table('transportasi', function (Blueprint $table) {
                $table->text('deskripsi_en')->nullable()->after('deskripsi');
            });
        }
    }
};
