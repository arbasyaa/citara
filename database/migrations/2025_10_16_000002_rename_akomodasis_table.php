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
        if (Schema::hasTable('akomodasis') && ! Schema::hasTable('akomodasi')) {
            Schema::rename('akomodasis', 'akomodasi');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('akomodasi') && ! Schema::hasTable('akomodasis')) {
            Schema::rename('akomodasi', 'akomodasis');
        }
    }
};
