<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('destinasi')) {
            Schema::table('destinasi', function (Blueprint $table) {
                $table->boolean('is_popular')->default(false)->after('url_gmaps');
                $table->boolean('is_featured')->default(false)->after('is_popular');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('destinasi')) {
            Schema::table('destinasi', function (Blueprint $table) {
                $table->dropColumn(['is_popular', 'is_featured']);
            });
        }
    }
};
