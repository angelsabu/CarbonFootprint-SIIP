<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('footprints', function (Blueprint $table) {
            $table->decimal('water_usage', 8, 2)->nullable()->after('food_score');
            $table->text('notes')->nullable()->after('impact_level');
            $table->text('recommendation')->nullable()->after('notes');
        });
    }

    public function down()
    {
        Schema::table('footprints', function (Blueprint $table) {
            $table->dropColumn(['water_usage', 'notes', 'recommendation']);
        });
    }
};
