@extends('adminlte::page')

@section('title', 'Tithe Dashboard')

@section('content_header')
<h1 class="font-weight-bold text-primary">
    <i class="fas fa-donate"></i> Tithe Dashboard
</h1>
@stop

@section('content')

<div class="row">

    {{-- TOTAL COLLECTION --}}
    <div class="col-lg-4 col-12">
        <div class="small-box bg-success shadow">
            <div class="inner">
                <h3>{{ number_format($totalTithes, 0, '.', ',') }} Tsh</h3>
                <p>Total Tithes Collected</p>
            </div>
            <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
        </div>
    </div>

    {{-- PARISH COUNT --}}
    <div class="col-lg-4 col-12">
        <div class="small-box bg-primary shadow">
            <div class="inner">
                <h3>{{ $parishTotals->count() }}</h3>
                <p>Parishes Reporting</p>
            </div>
            <div class="icon"><i class="fas fa-church"></i></div>
        </div>
    </div>

    {{-- TOP SCC COUNT --}}
    <div class="col-lg-4 col-12">
        <div class="small-box bg-purple shadow">
            <div class="inner">
                <h3>{{ $topScc->count() }}</h3>
                <p>Top Performing SCCs</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>

</div>

{{-- CHARTS ROW --}}
<div class="row">

    {{-- MONTHLY TREND --}}
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h3 class="card-title"><i class="fas fa-chart-line"></i> Monthly Tithe Trend</h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyTrendChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- PARISH COMPARISON --}}
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title"><i class="fas fa-chart-bar"></i> Parish Comparison</h3>
            </div>
            <div class="card-body">
                <canvas id="parishChart" height="120"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- TOP SCC TABLE --}}
<div class="card shadow mt-4">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title"><i class="fas fa-trophy"></i> Top 5 SCCs</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="bg-light">
                <tr>
                    <th>SCC</th>
                    <th>Total (Tsh)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topScc as $t)
                <tr>
                    <td>{{ $t->name }}</td>
                    <td>{{ number_format($t->total, 0, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// MONTHLY TREND
const months = {!! json_encode($monthlyTrend->pluck('month')) !!};
const totals = {!! json_encode($monthlyTrend->pluck('total')) !!};

new Chart(document.getElementById('monthlyTrendChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Tithes (Tsh)',
            data: totals,
            borderColor: 'blue',
            backgroundColor: 'rgba(0,0,255,0.2)',
            tension: 0.3,
            fill: true
        }]
    }
});

// PARISH COMPARISON
new Chart(document.getElementById('parishChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($parishTotals->pluck('name')) !!},
        datasets: [{
            label: 'Amount (Tsh)',
            data: {!! json_encode($parishTotals->pluck('tithes_sum_amount')) !!},
            backgroundColor: 'orange'
        }]
    }
});
</script>
@stop