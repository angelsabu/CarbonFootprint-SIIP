<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('footprints', function (Blueprint $table) {
            $table->id();
            $table->decimal('travel_km', 8, 2);
            $table->decimal('electricity_units', 8, 2);
            $table->decimal('food_score', 5, 2);
            $table->decimal('carbon_value', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('footprints');
    }
};
