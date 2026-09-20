<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('footprints', function (Blueprint $table) {
            $table->string('impact_level')->nullable()->default('Unknown')->after('carbon_value');
        });
    }

    public function down()
    {
        Schema::table('footprints', function (Blueprint $table) {
            $table->dropColumn('impact_level');
        });
    }
};
