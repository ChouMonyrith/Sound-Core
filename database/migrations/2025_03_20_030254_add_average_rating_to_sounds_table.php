<?php
// filepath: c:\Users\rithc\OneDrive\Desktop\php-Program\SoundCatalog\sound-catalog\database\migrations\2025_03_20_000001_add_average_rating_to_sounds_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAverageRatingToSoundsTable extends Migration
{
    public function up()
    {
        Schema::table('sounds', function (Blueprint $table) {
            $table->decimal('average_rating', 4, 2)->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('sounds', function (Blueprint $table) {
            $table->dropColumn('average_rating');
        });
    }
}