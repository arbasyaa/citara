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
                if (! Schema::hasColumn('akomodasi', 'slug')) {
                    $table->string('slug')->nullable()->unique()->after('nama');
                }
            });
        }

        if (Schema::hasTable('transportasi')) {
            Schema::table('transportasi', function (Blueprint $table) {
                if (! Schema::hasColumn('transportasi', 'slug')) {
                    $table->string('slug')->nullable()->unique()->after('nama');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('akomodasi')) {
            Schema::table('akomodasi', function (Blueprint $table) {
                if (Schema::hasColumn('akomodasi', 'slug')) {
                    $table->dropColumn('slug');
                }
            });
        }

        if (Schema::hasTable('transportasi')) {
            Schema::table('transportasi', function (Blueprint $table) {
                if (Schema::hasColumn('transportasi', 'slug')) {
                    $table->dropColumn('slug');
                }
            });
        }
    }
};
