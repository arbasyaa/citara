<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('destinasi') && ! Schema::hasColumn('destinasi', 'tipe')) {
            Schema::table('destinasi', function (Blueprint $table) {
                $table->string('tipe', 50)->default('wisata')->after('nama');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('destinasi') && Schema::hasColumn('destinasi', 'tipe')) {
            Schema::table('destinasi', function (Blueprint $table) {
                $table->dropColumn('tipe');
            });
        }
    }
};
