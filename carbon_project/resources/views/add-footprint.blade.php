@extends('layout')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="glass-card p-4">
            <h3 class="page-title mb-1">➕ Add Footprint</h3>
            <p style="color:#64748b; font-size:0.9rem;" class="mb-4">Enter your daily activity details</p>

            <form action="/store" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">🚗 Travel Distance (KM)</label>
                    <input type="number" name="travel_km" class="form-control" placeholder="e.g. 10" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">⚡ Electricity Usage (Units)</label>
                    <input type="number" name="electricity_units" class="form-control" placeholder="e.g. 5" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">🍽️ Food Score (1 - 10)</label>
                    <input type="number" name="food_score" class="form-control" placeholder="e.g. 6" min="1" max="10" step="0.1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">💧 Water Usage (Liters)</label>
                    <input type="number" name="water_usage" class="form-control" placeholder="e.g. 50" step="0.01">
                </div>

                <div class="mb-4">
                    <label class="form-label">📝 Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Any additional notes..."></textarea>
                </div>

                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-check-circle me-2"></i>Save Carbon Data
                </button>
            </form>
        </div>
    </div>
</div>

@endsection