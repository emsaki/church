@extends('adminlte::page')

@section('title', 'Tithe Dashboard')

@section('content_header')
<h1 class="font-weight-bold text-primary">
    <i class="fas fa-chart-line"></i> Tithe Dashboard – {{ $leaderScc->name }}
</h1>
@stop

@section('content')

<div class="row">

    {{-- Weekly --}}
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($weekTotal) }} Tsh</h3>
                <p>This Week</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-week"></i></div>
        </div>
    </div>

    {{-- Monthly --}}
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($monthTotal) }} Tsh</h3>
                <p>This Month</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
        </div>
    </div>

    {{-- Yearly --}}
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($yearTotal) }} Tsh</h3>
                <p>This Year</p>
            </div>
            <div class="icon"><i class="fas fa-calendar"></i></div>
        </div>
    </div>

</div>

{{-- TOP CONTRIBUTORS --}}
<div class="card shadow mt-4">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-trophy"></i> Top Contributors</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>Member</th>
                    <th>Total Giving</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topMembers as $tm)
                <tr>
                    <td>{{ $tm->member->full_name }}</td>
                    <td>{{ number_format($tm->total) }} Tsh</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- TREND CHART --}}
<div class="card shadow mt-4">
    <div class="card-header bg-secondary text-white">
        <h3 class="card-title"><i class="fas fa-chart-bar"></i> Monthly Trend</h3>
    </div>
    <div class="card-body">
        <canvas id="titheChart"></canvas>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($monthlyTrend->pluck('month')) !!};
    const data = {!! json_encode($monthlyTrend->pluck('total')) !!};

    new Chart(document.getElementById('titheChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Tithes',
                data: data,
                borderColor: 'blue',
                fill: false,
                tension: 0.3
            }]
        }
    });
</script>
@stop