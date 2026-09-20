<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Footprint;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\StoreFootprintRequest;
use App\Http\Requests\UpdateFootprintRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FootprintController extends Controller
{
    public function index()
{
    $data = \App\Models\Footprint::with('user')
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
        $totalHighImpact = $data->where('impact_level', 'High Impact')->count();
        $totalCO2 = round($data->sum('carbon_value'), 2);
        $avgCO2 = $data->count() > 0 ? round($data->avg('carbon_value'), 2) : 0;
        $maxCO2 = $data->count() > 0 ? round($data->max('carbon_value'), 2) : 0;

        $matchedPredictions = $data->filter(function ($item) {
            return $item->ml_prediction === $item->impact_level;
        })->count();
        $mlAccuracy = $data->count() > 0 ? round(($matchedPredictions / $data->count()) * 100, 1) : 100;

        return view('dashboard', compact('data', 'totalHighImpact', 'totalCO2', 'avgCO2', 'maxCO2', 'mlAccuracy'));
    }

    // Show form page
    public function create()
    {
        return view('add-footprint');
    }

    // Store data + Carbon calculation
    public function store(StoreFootprintRequest $request)
    {
        $data = $request->validated();

        $waterUsage = (float) ($data['water_usage'] ?? 0);

        $carbon = ($data['travel_km'] * 0.21)
                + ($data['electricity_units'] * 0.85)
                + ($data['food_score'] * 1.5)
                + ($waterUsage * 0.05);

        $impact = $this->classifyImpact($carbon);

        $mlPrediction = $this->predictMlImpact(
            array_merge($data, ['water_usage' => $waterUsage]),
            $carbon
        );

        $predictionToStore = $mlPrediction ?? $impact;

        $recommendation = $this->generateRecommendation($data, $carbon, $predictionToStore);

        Footprint::create(array_merge($data, [
    'user_id' => auth()->id(),
    'carbon_value' => $carbon,
    'impact_level' => $impact,
    'ml_prediction' => $predictionToStore,
    'recommendation' => $recommendation,
]));

        return redirect('/dashboard')->with('success', 'Data Added Successfully');
    }

    public function edit($id)
    {
        $data = Footprint::find($id);
        return view('edit-footprint', compact('data'));
    }

    public function update(UpdateFootprintRequest $request, $id)
    {
        $data = $request->validated();

        $waterUsage = (float) ($data['water_usage'] ?? 0);

        $carbon = ($data['travel_km'] * 0.21)
                + ($data['electricity_units'] * 0.85)
                + ($data['food_score'] * 1.5)
                + ($waterUsage * 0.05);

        $impact = $this->classifyImpact($carbon);

        $mlPrediction = $this->predictMlImpact(
            array_merge($data, ['water_usage' => $waterUsage]),
            $carbon
        );

        $predictionToStore = $mlPrediction ?? $impact;

        $recommendation = $this->generateRecommendation($data, $carbon, $predictionToStore);

        $record = Footprint::findOrFail($id);

        $record->update(array_merge($data, [
            'carbon_value' => $carbon,
            'impact_level' => $impact,
            'ml_prediction' => $predictionToStore,
            'recommendation' => $recommendation,
        ]));

        return redirect('/dashboard')->with('success', 'Updated Successfully');
    }

    // Delete record
    public function destroy($id)
    {
        Footprint::find($id)->delete();
        return redirect('/dashboard')->with('success', 'Deleted Successfully');
    }

    // Export CSV
    public function exportCsv(Request $request)
    {
        $query = Footprint::query();

        if ($request->filled('impact')) {
            $query->where('impact_level', $request->impact);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $fileName = 'footprints_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'id','travel_km','electricity_units','food_score',
                'water_usage','carbon_value','impact_level',
                'ml_prediction','recommendation','notes','created_at'
            ]);

            foreach ($query->cursor() as $row) {
                fputcsv($handle, [
                    $row->id,
                    $row->travel_km,
                    $row->electricity_units,
                    $row->food_score,
                    $row->water_usage,
                    $row->carbon_value,
                    $row->impact_level,
                    $row->ml_prediction,
                    $row->recommendation,
                    $row->notes,
                    $row->created_at,
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set(
            'Content-Disposition',
            'attachment; filename="' . $fileName . '"'
        );

        return $response;
    }

    // Impact classification
    private function classifyImpact(float $carbon): string
    {
        if ($carbon < 5) return 'Low Impact';
        if ($carbon <= 15) return 'Medium Impact';
        return 'High Impact';
    }

    // ML prediction
    private function predictMlImpact(array $features, float $carbon): ?string
    {
        $mlUrl = env('ML_SERVICE_URL');

        if (!$mlUrl) return null;

        try {
            $payload = [
                'travel_km' => $features['travel_km'] ?? 0,
                'electricity_units' => $features['electricity_units'] ?? 0,
                'food_score' => $features['food_score'] ?? 0,
                'water_liters' => $features['water_usage'] ?? 0,
                'carbon_value' => $carbon,
            ];

            $response = Http::retry(3, 100)
                ->post(rtrim($mlUrl, '/') . '/predict', $payload);

            if ($response->ok()) {
                $body = $response->json();
                return $body['label'] ?? $body['prediction'] ?? null;
            }
        } catch (\Exception $e) {}

        return null;
    }

    // Recommendations
    private function generateRecommendation(array $features, float $carbon, string $prediction): string
    {
        $recommendations = [];

        if ($prediction === 'High Impact') {
            $recommendations[] = 'High impact detected — reduce travel and electricity usage.';
        } elseif ($prediction === 'Medium Impact') {
            $recommendations[] = 'Moderate impact — improve daily habits.';
        } else {
            $recommendations[] = 'Low impact — great job!';
        }

        if (($features['water_usage'] ?? 0) > 100) {
            $recommendations[] = 'Reduce water usage.';
        }

        if (($features['travel_km'] ?? 0) > 50) {
            $recommendations[] = 'Use public transport.';
        }

        if (($features['electricity_units'] ?? 0) > 10) {
            $recommendations[] = 'Use energy-saving appliances.';
        }

        if (($features['food_score'] ?? 0) > 7) {
            $recommendations[] = 'Choose lower-impact food options.';
        }

        return implode(' ', $recommendations);
    }
}