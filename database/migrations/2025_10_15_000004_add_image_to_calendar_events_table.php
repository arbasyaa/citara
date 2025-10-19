<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('calendar_events', 'image')) {
            Schema::table('calendar_events', function (Blueprint $table) {
                $table->string('image')->nullable()->after('description');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('calendar_events', 'image')) {
            Schema::table('calendar_events', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
};
