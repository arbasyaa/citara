<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToServicesTable extends Migration
{
    public function up()
    {
        if (! Schema::hasColumn('services', 'image')) {
            Schema::table('services', function (Blueprint $table) {
                $table->string('image')->nullable()->after('link');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('services', 'image')) {
            Schema::table('services', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }
    }
}
