<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Footprint;

class FootprintMlIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_uses_ml_service_label()
    {
        // Fake ML service response
        Http::fake([
            '*' => Http::response(['label' => 'Medium Impact'], 200),
        ]);

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('store.footprint'), [
            'travel_km' => 10,
            'electricity_units' => 5,
            'food_score' => 4,
            'water_usage' => 15,
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('footprints', [
            'travel_km' => 10,
            'impact_level' => 'Medium Impact',
            'ml_prediction' => 'Medium Impact',
        ]);
    }

    public function test_store_falls_back_when_ml_service_fails()
    {
        Http::fake([
            '*' => Http::response(null, 500),
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('store.footprint'), [
            'travel_km' => 2,
            'electricity_units' => 1,
            'food_score' => 1,
            'water_usage' => 5,
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('footprints', [
            'travel_km' => 2,
            'impact_level' => 'Low Impact',
            'ml_prediction' => 'Low Impact',
        ]);
    }
}
