@extends('layout')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">📊 My Dashboard</h2>
    <a href="/add" class="btn btn-nav-primary">
        <i class="bi bi-plus-lg"></i> Add Footprint
    </a>
</div>

<!-- Metric Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="metric-card">
            <div class="metric-label">🚨 High-Impact Logs</div>
            <div class="metric-value" style="color:#f87171;">{{ $totalHighImpact }}</div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="metric-card">
            <div class="metric-label">🌍 Total CO₂</div>
            <div class="metric-value" style="color:#fb923c;">{{ $totalCO2 }}<span style="font-size:1rem;"> kg</span></div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="metric-card">
            <div class="metric-label">📊 Avg CO₂</div>
            <div class="metric-value" style="color:#facc15;">{{ $avgCO2 }}<span style="font-size:1rem;"> kg</span></div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6">
        <div class="metric-card">
            <div class="metric-label">🔥 Peak CO₂</div>
            <div class="metric-value" style="color:#f43f5e;">{{ $maxCO2 }}<span style="font-size:1rem;"> kg</span></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="metric-card">
            <div class="metric-label">🤖 ML Accuracy</div>
            <div class="metric-value" style="color:#34d399;">{{ $mlAccuracy }}<span style="font-size:1rem;">%</span></div>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="glass-card p-4 mb-4">
    <div class="section-title">📈 CO₂ Emission Trend</div>
    @if($data->isEmpty())
        <p class="text-center py-5" style="color:#475569;">No data available yet.</p>
    @else
        <div style="height: 260px;">
            <canvas id="footprintChart"></canvas>
        </div>
    @endif
</div>

<!-- History Table -->
<div class="glass-card p-4">
    <div class="section-title">📋 Carbon Footprint History</div>
    <div class="table-responsive">
        <table class="table custom-table mb-0">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Travel 🚗</th>
                    <th>Electricity ⚡</th>
                    <th>Food 🍔</th>
                    <th>Water 💧</th>
                    <th>Carbon 🌍</th>
                    <th>Impact</th>
                    <th>ML 🤖</th>
                    <th>Recommendation</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $item->user->name ?? 'You' }}</td>
                    <td>{{ $item->travel_km }} km</td>
                    <td>{{ $item->electricity_units }}</td>
                    <td>{{ $item->food_score }}</td>
                    <td>{{ $item->water_usage }} L</td>
                    <td><strong style="color:#f87171;">{{ $item->carbon_value }}</strong></td>
                    <td>
                        @if($item->impact_level == 'High Impact')
                            <span class="badge-high">{{ $item->impact_level }}</span>
                        @elseif($item->impact_level == 'Medium Impact')
                            <span class="badge-medium">{{ $item->impact_level }}</span>
                        @else
                            <span class="badge-low">{{ $item->impact_level }}</span>
                        @endif
                    </td>
                    <td>
                        @if($item->ml_prediction == 'High Impact')
                            <span class="badge-high">{{ $item->ml_prediction }}</span>
                        @elseif($item->ml_prediction == 'Medium Impact')
                            <span class="badge-medium">{{ $item->ml_prediction }}</span>
                        @else
                            <span class="badge-low">{{ $item->ml_prediction }}</span>
                        @endif
                    </td>
                    <td style="max-width:220px; font-size:0.82rem; color:#94a3b8;">{{ $item->recommendation }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="/edit/{{ $item->id }}" class="btn btn-edit">Edit</a>
                            <a href="/delete/{{ $item->id }}" class="btn btn-delete" onclick="return confirm('Delete?')">Delete</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5" style="color:#475569;">No footprint data found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if(!$data->isEmpty())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('footprintChart').getContext('2d');

    const sortedData = [...@json($data->values())].reverse();
    const labels = sortedData.map(item => item.created_at ? new Date(item.created_at).toLocaleString('en-US', { month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit' }) : '');
    const carbonValues = sortedData.map(item => item.carbon_value);

    const gradient = ctx.createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.02)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Carbon Value (kg CO₂)',
                data: carbonValues,
                borderColor: '#059669',
                backgroundColor: gradient,
                borderWidth: 3.5,
                fill: true,
                tension: 0.45,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#059669',
                pointBorderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#059669',
                pointHoverBorderColor: '#ffffff',
                cubicInterpolationMode: 'monotone'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    labels: { color: '#334155', font: { weight: '600', size: 13 } }
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#f1f5f9',
                    bodyColor: '#e2e8f0',
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { size: 11 } }
                },
                y: {
                    grid: { color: 'rgba(15,23,42,0.06)' },
                    ticks: { color: '#64748b' },
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endif

@endsection