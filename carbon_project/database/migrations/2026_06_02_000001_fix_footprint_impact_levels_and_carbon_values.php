<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('footprints', function (Blueprint $table) {
            if (!Schema::hasColumn('footprints', 'carbon_value')) {
                $table->decimal('carbon_value', 10, 2)->default(0)->after('food_score');
            }
            if (!Schema::hasColumn('footprints', 'impact_level')) {
                $table->string('impact_level')->default('Unknown')->after('carbon_value');
            }
        });

        $footprints = DB::table('footprints')->get();

        foreach ($footprints as $footprint) {
            $travel = (float) ($footprint->travel_km ?? 0);
            $electricity = (float) ($footprint->electricity_units ?? 0);
            $food = (float) ($footprint->food_score ?? 0);
            $water = (float) ($footprint->water_usage ?? 0);

            $carbon = ($travel * 0.21) + ($electricity * 0.85) + ($food * 1.5) + ($water * 0.05);
            $impact = $carbon < 5
                ? 'Low Impact'
                : ($carbon <= 15 ? 'Medium Impact' : 'High Impact');

            $needsImpact = !isset($footprint->impact_level) || $footprint->impact_level === null || trim($footprint->impact_level) === '' || strtolower($footprint->impact_level) === 'unknown';

            DB::table('footprints')
                ->where('id', $footprint->id)
                ->update([
                    'carbon_value' => round($carbon, 2),
                    'impact_level' => $needsImpact ? $impact : $footprint->impact_level,
                ]);
        }
    }

    public function down()
    {
        // Keep columns to preserve stored footprint data.
    }
};
