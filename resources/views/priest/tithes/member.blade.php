@extends('adminlte::page')

@section('title', 'Member Tithe History')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-user"></i> Member Tithe History
    </h1>
@stop

@section('content')

<div class="card shadow-lg">

    <div class="card-header bg-info text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-donate"></i> Contribution Details
        </h3>
    </div>

    <div class="card-body">

        <div class="alert alert-secondary">
            <strong>Total Given:</strong>
            {{ number_format($total, 0, '.', ',') }} Tsh
        </div>

        <table class="table table-bordered table-striped">
            <thead class="bg-light">
                <tr>
                    <th>Date</th>
                    <th>Amount (Tsh)</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tithes as $t)
                    <tr>
                        <td>{{ $t->tithe_date }}</td>
                        <td>{{ number_format($t->amount, 0, '.', ',') }}</td>
                    </tr>
                @endforeach

                @if($tithes->isEmpty())
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            No contributions recorded.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>

</div>

@stop