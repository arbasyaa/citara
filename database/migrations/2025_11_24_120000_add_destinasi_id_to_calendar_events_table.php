<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('calendar_events')) {
            return;
        }

        Schema::table('calendar_events', function (Blueprint $table) {
            if (! Schema::hasColumn('calendar_events', 'destinasi_id')) {
                $table->foreignId('destinasi_id')
                    ->nullable()
                    ->constrained('destinasi')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('calendar_events')) {
            return;
        }

        Schema::table('calendar_events', function (Blueprint $table) {
            if (Schema::hasColumn('calendar_events', 'destinasi_id')) {
                $table->dropForeign(['destinasi_id']);
                $table->dropColumn('destinasi_id');
            }
        });
    }
};
