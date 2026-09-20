@extends('layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="glass-card p-4">
            <h3 class="page-title mb-1">✏️ Edit Footprint</h3>
            <p style="color:#64748b; font-size:0.9rem;" class="mb-4">Update your carbon data</p>

            <form action="/update/{{ $data->id }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">🚗 Travel Distance (KM)</label>
                    <input type="number" name="travel_km" value="{{ $data->travel_km }}" class="form-control" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">⚡ Electricity Usage (Units)</label>
                    <input type="number" name="electricity_units" value="{{ $data->electricity_units }}" class="form-control" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">🍽️ Food Score (1 - 10)</label>
                    <input type="number" name="food_score" value="{{ $data->food_score }}" class="form-control" min="1" max="10" step="0.1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">💧 Water Usage (Liters)</label>
                    <input type="number" name="water_usage" value="{{ $data->water_usage }}" class="form-control" step="0.01">
                </div>

                <div class="mb-4">
                    <label class="form-label">📝 Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3">{{ $data->notes }}</textarea>
                </div>

                <button type="submit" class="btn btn-submit" style="background: #f59e0b;">
                    <i class="bi bi-pencil-square me-2"></i>Update Data
                </button>
            </form>
        </div>
    </div>
</div>

@endsection