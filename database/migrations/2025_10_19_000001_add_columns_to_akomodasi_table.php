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
        if (Schema::hasTable('akomodasi')) {
            Schema::table('akomodasi', function (Blueprint $table) {
                if (! Schema::hasColumn('akomodasi', 'nama')) {
                    $table->string('nama')->nullable();
                }
                if (! Schema::hasColumn('akomodasi', 'tipe')) {
                    $table->string('tipe')->nullable()->after('nama');
                }
                if (! Schema::hasColumn('akomodasi', 'lokasi')) {
                    $table->string('lokasi')->nullable()->after('tipe');
                }
                if (! Schema::hasColumn('akomodasi', 'nomor_telepon')) {
                    $table->string('nomor_telepon')->nullable()->after('lokasi');
                }
                if (! Schema::hasColumn('akomodasi', 'url_situs_web')) {
                    $table->string('url_situs_web')->nullable()->after('nomor_telepon');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('akomodasi')) {
            Schema::table('akomodasi', function (Blueprint $table) {
                foreach (['url_situs_web','nomor_telepon','lokasi','tipe','nama'] as $col) {
                    if (Schema::hasColumn('akomodasi', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
