<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            if (!Schema::hasColumn('calendar_events', 'year')) {
                $table->integer('year')->nullable()->after('month');
            }
            if (!Schema::hasColumn('calendar_events', 'start_date')) {
                $table->date('start_date')->nullable()->after('year');
            }
            if (!Schema::hasColumn('calendar_events', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('calendar_events', function (Blueprint $table) {
            if (Schema::hasColumn('calendar_events', 'end_date')) {
                $table->dropColumn('end_date');
            }
            if (Schema::hasColumn('calendar_events', 'start_date')) {
                $table->dropColumn('start_date');
            }
            if (Schema::hasColumn('calendar_events', 'year')) {
                $table->dropColumn('year');
            }
        });
    }
};
