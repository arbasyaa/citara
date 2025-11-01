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
        // Add English description to transportasi table (already has deskripsi)
        Schema::table('transportasi', function (Blueprint $table) {
            if (!Schema::hasColumn('transportasi', 'deskripsi_en')) {
                $table->text('deskripsi_en')->nullable()->after('deskripsi');
            }
        });

        // Add both Indonesian and English descriptions to akomodasi table
        Schema::table('akomodasi', function (Blueprint $table) {
            if (!Schema::hasColumn('akomodasi', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('tipe');
            }
            if (!Schema::hasColumn('akomodasi', 'deskripsi_en')) {
                $table->text('deskripsi_en')->nullable()->after('deskripsi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transportasi', function (Blueprint $table) {
            if (Schema::hasColumn('transportasi', 'deskripsi_en')) {
                $table->dropColumn('deskripsi_en');
            }
        });

        Schema::table('akomodasi', function (Blueprint $table) {
            $columns = ['deskripsi_en', 'deskripsi'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('akomodasi', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
