@extends('adminlte::page')

@section('title', 'Tithe – Parish Summary')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-church"></i> Parish Tithe Summary – {{ $parish->name }}
    </h1>
@stop

@section('content')

<div class="row">

    {{-- SCC SUMMARY --}}
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-users"></i> SCC Breakdown
                </h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>SCC Name</th>
                            <th>Members</th>
                            <th>Tithes</th>
                            <th style="width:100px;">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parish->communities as $c)
                            <tr>
                                <td>{{ $c->name }}</td>
                                <td>{{ $c->members->count() }}</td>
                                <td>
                                    {{ number_format(
                                        $c->tithes?->sum('amount') ?? 0, 
                                        0, '.', ','
                                    ) }} Tsh
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('priest.tithes.scc', $c) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MONTHLY TOTALS --}}
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-calendar-alt"></i> Monthly Tithe Totals
                </h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th>Month</th>
                            <th>Total (Tsh)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyTotals as $m)
                            <tr>
                                <td>{{ $m->month }}</td>
                                <td>{{ number_format($m->total, 0, '.', ',') }}</td>
                            </tr>
                        @endforeach

                        @if($monthlyTotals->isEmpty())
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    No tithes recorded yet.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@stop