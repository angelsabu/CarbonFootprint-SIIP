<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('footprints', function (Blueprint $table) {
            if (!Schema::hasColumn('footprints', 'ml_prediction')) {
                $table->string('ml_prediction')->nullable()->after('impact_level');
            }
        });
    }

    public function down()
    {
        Schema::table('footprints', function (Blueprint $table) {
            if (Schema::hasColumn('footprints', 'ml_prediction')) {
                $table->dropColumn('ml_prediction');
            }
        });
    }
};
