<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoDestinasisTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
                if (! Schema::hasTable('foto_destinasi')) {
            Schema::create('foto_destinasi', function (Blueprint $table) {
                $table->id();
                // the application uses the singular `destinasi` table and the SQL dump references `destinasi`.
                $table->foreignId('id_destinasi')->constrained('destinasi')->onDelete('cascade');
                $table->string('url');
                $table->string('keterangan')->nullable();
                $table->boolean('apakah_slider_utama')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_destinasi');
    }
}
