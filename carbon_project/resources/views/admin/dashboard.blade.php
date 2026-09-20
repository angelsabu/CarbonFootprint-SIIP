@extends('layout')

@section('content')

<div class="container py-4">

<h2 class="mb-4">👨‍💼 Admin Dashboard</h2>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="row mb-4">

    <div class="col-md-3">
        <div class="card shadow text-center">
            <div class="card-body">
                <h6>Total Users</h6>
                <h2>{{ $totalUsers }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow text-center">
            <div class="card-body">
                <h6>Total Records</h6>
                <h2>{{ $totalRecords }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow text-center">
            <div class="card-body">
                <h6>Average Carbon</h6>
                <h2>{{ $averageCarbon }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow text-center">
            <div class="card-body">
                <h6>High Impact</h6>
                <h2>{{ $highImpactUsers }}</h2>
            </div>
        </div>
    </div>

</div>

<div class="card shadow p-4 mb-4" style="background: #ffffff; border: 1px solid #cbd5e1;">
    <h4 class="mb-4">📈 Carbon Analytics</h4>
    <div style="max-width: 320px; margin: 0 auto;">
        <canvas id="impactChart"></canvas>
    </div>
</div>

<div class="card shadow p-4 mb-4">

    <h4>👥 User Management</h4>

    <table class="table table-bordered table-hover">

        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        @foreach($users as $user)

            <tr>

                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>
                    @if($user->role == 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @else
                        <span class="badge bg-primary">User</span>
                    @endif
                </td>

                <td>

                    @if($user->role == 'admin')

                        <span class="text-muted">
                            Protected Admin
                        </span>

                    @else

                        <a href="/admin/delete-user/{{ $user->id }}"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this user?')">
                            Delete
                        </a>

                    @endif

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<div class="card shadow p-4">

    <h4>📊 Carbon Footprint Records</h4>

    <table class="table table-bordered table-striped">

        <thead class="table-light">

            <tr>
                <th>User</th>
                <th>Travel KM</th>
                <th>Electricity</th>
                <th>Food Score</th>
                <th>Water Usage</th>
                <th>Carbon Value</th>
                <th>Impact</th>
                <th>Prediction</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>

        @foreach($footprints as $item)

            <tr>

                <td>{{ $item->user->name ?? 'Unknown User' }}</td>
                <td>{{ $item->travel_km }}</td>
                <td>{{ $item->electricity_units }}</td>
                <td>{{ $item->food_score }}</td>
                <td>{{ $item->water_usage }}</td>
                <td>{{ $item->carbon_value }}</td>

                <td>

                    @if($item->impact_level == 'Low Impact')
                        <span class="badge bg-success">
                            {{ $item->impact_level }}
                        </span>

                    @elseif($item->impact_level == 'Medium Impact')
                        <span class="badge bg-warning text-dark">
                            {{ $item->impact_level }}
                        </span>

                    @else
                        <span class="badge bg-danger">
                            {{ $item->impact_level }}
                        </span>
                    @endif

                </td>

                <td>{{ $item->ml_prediction }}</td>

                <td>

                    <a href="/admin/delete-footprint/{{ $item->id }}"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this record?')">
                        Delete
                    </a>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('impactChart');

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Low Impact',
            'Medium Impact',
            'High Impact'
        ],
        datasets: [{
            data: [
                {{ $lowCount }},
                {{ $mediumCount }},
                {{ $highCount }}
            ],
            backgroundColor: [
                '#10b981',
                '#fbbf24',
                '#ef4444'
            ],
            borderColor: 'rgba(255, 255, 255, 0.1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#1e293b',
                    font: {
                        family: "'Inter', sans-serif",
                        size: 13
                    }
                }
            }
        }
    }
});

</script>

@endsection