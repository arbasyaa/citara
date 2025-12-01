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
        // Add indexes to destinasi table for better query performance
        Schema::table('destinasi', function (Blueprint $table) {
            $table->index('is_popular', 'destinasi_is_popular_index');
            $table->index('is_featured', 'destinasi_is_featured_index');
            $table->index(['is_popular', 'is_featured'], 'destinasi_popular_featured_index');
        });

        // Add indexes to calendar_events table
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->index('year', 'calendar_events_year_index');
            $table->index('month', 'calendar_events_month_index');
            $table->index('destinasi_id', 'calendar_events_destinasi_id_index');
            $table->index(['year', 'month'], 'calendar_events_year_month_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            $table->dropIndex('destinasi_is_popular_index');
            $table->dropIndex('destinasi_is_featured_index');
            $table->dropIndex('destinasi_popular_featured_index');
        });

        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropIndex('calendar_events_year_index');
            $table->dropIndex('calendar_events_month_index');
            $table->dropIndex('calendar_events_destinasi_id_index');
            $table->dropIndex('calendar_events_year_month_index');
        });
    }
};
