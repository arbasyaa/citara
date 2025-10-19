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
        if (Schema::hasTable('transportasi')) {
            Schema::table('transportasi', function (Blueprint $table) {
                if (! Schema::hasColumn('transportasi', 'nama')) {
                    $table->string('nama')->nullable();
                }
                if (! Schema::hasColumn('transportasi', 'tipe')) {
                    $table->string('tipe')->nullable()->after('nama');
                }
                if (! Schema::hasColumn('transportasi', 'rute')) {
                    $table->string('rute')->nullable()->after('tipe');
                }
                if (! Schema::hasColumn('transportasi', 'deskripsi')) {
                    $table->text('deskripsi')->nullable()->after('rute');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('transportasi')) {
            Schema::table('transportasi', function (Blueprint $table) {
                foreach (['deskripsi','rute','tipe','nama'] as $col) {
                    if (Schema::hasColumn('transportasi', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
