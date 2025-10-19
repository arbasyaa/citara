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
        if (Schema::hasTable('transportasis') && ! Schema::hasTable('transportasi')) {
            Schema::rename('transportasis', 'transportasi');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('transportasi') && ! Schema::hasTable('transportasis')) {
            Schema::rename('transportasi', 'transportasis');
        }
    }
};
