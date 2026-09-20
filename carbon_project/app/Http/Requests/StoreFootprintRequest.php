<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFootprintRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'travel_km' => 'required|numeric|min:0',
            'electricity_units' => 'required|numeric|min:0',
            'food_score' => 'required|numeric|min:0|max:10',
            'water_usage' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
