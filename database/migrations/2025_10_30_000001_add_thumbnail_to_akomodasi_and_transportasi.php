<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('akomodasi')) {
            Schema::table('akomodasi', function (Blueprint $table) {
                if (! Schema::hasColumn('akomodasi', 'thumbnail')) {
                    $table->string('thumbnail')->nullable()->after('url_situs_web');
                }
            });
        }

        if (Schema::hasTable('transportasi')) {
            Schema::table('transportasi', function (Blueprint $table) {
                if (! Schema::hasColumn('transportasi', 'thumbnail')) {
                    $table->string('thumbnail')->nullable()->after('deskripsi');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('akomodasi')) {
            Schema::table('akomodasi', function (Blueprint $table) {
                if (Schema::hasColumn('akomodasi', 'thumbnail')) {
                    $table->dropColumn('thumbnail');
                }
            });
        }

        if (Schema::hasTable('transportasi')) {
            Schema::table('transportasi', function (Blueprint $table) {
                if (Schema::hasColumn('transportasi', 'thumbnail')) {
                    $table->dropColumn('thumbnail');
                }
            });
        }
    }
};
