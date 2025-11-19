<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('wilayah') && Schema::hasTable('destinasi')) {
            $exists = DB::selectOne(<<<SQL
                SELECT COUNT(*) AS cnt
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'destinasi'
                  AND COLUMN_NAME = 'id_wilayah'
                  AND REFERENCED_TABLE_NAME = 'wilayah'
            SQL);

            if (! $exists || (int) ($exists->cnt ?? 0) === 0) {
                Schema::table('destinasi', function (Blueprint $table) {
                    $table->foreign('id_wilayah')
                        ->references('id')
                        ->on('wilayah')
                        ->onDelete('cascade');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('destinasi')) {
            try {
                // Attempt to drop by conventional name
                Schema::table('destinasi', function (Blueprint $table) {
                    $table->dropForeign('destinasi_id_wilayah_foreign');
                });
            } catch (\Throwable $e) {
                try {
                    // Fallback: resolve actual constraint name and drop via raw SQL
                    $row = DB::selectOne(<<<SQL
                        SELECT CONSTRAINT_NAME AS name
                        FROM information_schema.KEY_COLUMN_USAGE
                        WHERE TABLE_SCHEMA = DATABASE()
                          AND TABLE_NAME = 'destinasi'
                          AND COLUMN_NAME = 'id_wilayah'
                          AND REFERENCED_TABLE_NAME = 'wilayah'
                        LIMIT 1
                    SQL);
                    if ($row && !empty($row->name)) {
                        DB::statement("ALTER TABLE `destinasi` DROP FOREIGN KEY `{$row->name}`");
                    }
                } catch (\Throwable $e2) {
                    // ignore
                }
            }
        }
    }
};
