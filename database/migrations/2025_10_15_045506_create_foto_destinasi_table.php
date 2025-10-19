// DUPLICATE MIGRATION MOVED: 2025_10_15_045506_create_foto_destinasi_table.php
// This file was renamed to avoid duplicate migration errors in test environment.
// Original content moved to 2025_10_15_045506_create_foto_destinasi_table.php.bak
return;

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
        Schema::create('foto_destinasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_destinasi')->constrained('destinasi')->onDelete('cascade');
            $table->string('url');
            $table->string('keterangan')->nullable();
            $table->boolean('apakah_slider_utama')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_destinasi');
    }
};
