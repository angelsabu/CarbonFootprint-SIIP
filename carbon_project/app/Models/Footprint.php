<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footprint extends Model
{
    protected $fillable = [
        'user_id',
        'travel_km',
        'electricity_units',
        'food_score',
        'water_usage',
        'carbon_value',
        'impact_level',
        'ml_prediction',
        'notes',
        'recommendation',
    ];

    protected $casts = [
        'travel_km' => 'float',
        'electricity_units' => 'float',
        'food_score' => 'float',
        'carbon_value' => 'float',
        'water_usage' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}