@extends('adminlte::page')

@section('title', $parish->name)

@section('content_header')
    <h1>{{ $parish->name }}</h1>
@stop

@section('content')

<div class="card mb-4">
    <div class="card-body">
        <h4>Current Priest: {{ $parish->priest?->full_name ?? 'None' }}</h4>
    </div>
</div>

<div class="card">
    <div class="card-header">Priest Assignment History</div>
    <div class="card-body p-0">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Priest</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>
            @foreach($parish->priestHistory as $record)
                <tr>
                    <td>{{ $record->priest->full_name }}</td>
                    <td>{{ $record->assigned_from }}</td>
                    <td>{{ $record->assigned_to ?? 'Present' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop