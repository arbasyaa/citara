// DUPLICATE MIGRATION MOVED: 2025_10_15_000003_add_image_to_services_table.php
// Neutralized to prevent duplicate column creation during tests.
return;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('services', 'image')) {
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
};
