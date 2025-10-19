<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('destinasi')) {
            // Use raw SQL to alter columns to nullable for MySQL
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `destinasi` MODIFY `deskripsi` TEXT NULL");
                DB::statement("ALTER TABLE `destinasi` MODIFY `alamat_lokasi` TEXT NULL");
            } else {
                // Fallback: attempt to use Schema::table (may require doctrine/dbal)
                Schema::table('destinasi', function ($table) {
                    if (method_exists($table, 'text')) {
                        $table->text('deskripsi')->nullable()->change();
                        $table->text('alamat_lokasi')->nullable()->change();
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('destinasi')) {
            $driver = DB::getDriverName();
            if ($driver === 'mysql') {
                DB::statement("ALTER TABLE `destinasi` MODIFY `deskripsi` TEXT NOT NULL");
                DB::statement("ALTER TABLE `destinasi` MODIFY `alamat_lokasi` TEXT NOT NULL");
            } else {
                Schema::table('destinasi', function ($table) {
                    if (method_exists($table, 'text')) {
                        $table->text('deskripsi')->nullable(false)->change();
                        $table->text('alamat_lokasi')->nullable(false)->change();
                    }
                });
            }
        }
    }
};
