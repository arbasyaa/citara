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
        // Add English fields to destinasi table
        Schema::table('destinasi', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
        });

        // Add English fields to akomodasi table
        Schema::table('akomodasi', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
        });

        // Add English fields to transportasi table
        Schema::table('transportasi', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
            $table->text('rute_en')->nullable()->after('rute');
        });

        // Add English fields to wilayah table
        Schema::table('wilayah', function (Blueprint $table) {
            $table->string('nama_en')->nullable()->after('nama');
            $table->text('deskripsi_en')->nullable()->after('deskripsi');
        });

        // Add English fields to calendar_events table
        Schema::table('calendar_events', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->text('description_en')->nullable()->after('description');
            $table->string('location_en')->nullable()->after('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en']);
        });

        Schema::table('akomodasi', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en']);
        });

        Schema::table('transportasi', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en', 'rute_en']);
        });

        Schema::table('wilayah', function (Blueprint $table) {
            $table->dropColumn(['nama_en', 'deskripsi_en']);
        });

        Schema::table('calendar_events', function (Blueprint $table) {
            $table->dropColumn(['title_en', 'description_en', 'location_en']);
        });
    }
};
