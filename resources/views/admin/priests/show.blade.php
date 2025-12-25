@extends('adminlte::page')

@section('title', $priest->full_name)

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-user-tie text-primary"></i> {{ $priest->full_name }}
    </h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        {{-- PRIEST INFORMATION CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-id-card-alt"></i> Priest Information
                </h3>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $priest->full_name }}</p>
                        <p><strong>Email:</strong> {{ $priest->email ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ $priest->phone ?? '-' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Ordination Year:</strong> {{ $priest->ordination_year ?? '-' }}</p>
                        <p>
                            <strong>Status:</strong>
                            @if ($priest->active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </p>
                    </div>

                </div>

            </div>
        </div>


        {{-- CURRENT PARISH ASSIGNMENTS --}}
        <div class="card shadow mb-4">

            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-church"></i> Current Parish Assignments
                </h3>
            </div>

            <div class="card-body">

                @php
                    $currentAssignments = $priest->parishHistory->where('assigned_to', null);
                @endphp

                @if($currentAssignments->count())
                    @foreach($currentAssignments as $assign)
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            <strong>{{ $assign->parish->name }}</strong>

                            <br>
                            <small class="text-muted">
                                Assigned From: <strong>{{ \Carbon\Carbon::parse($assign->assigned_from)->format('Y-m-d') }}</strong>
                            </small>
                        </p>
                        <hr>
                    @endforeach
                @else
                    <p class="text-muted">This priest is not currently assigned to any parish.</p>
                @endif

            </div>
        </div>


        {{-- ASSIGNMENT HISTORY --}}
        <div class="card shadow">

            <div class="card-header bg-secondary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-history"></i> Assignment History
                </h3>
            </div>

            <div class="card-body p-0">

                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="40%">Parish</th>
                            <th width="30%">From</th>
                            <th width="30%">To</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($priest->parishHistory as $record)
                        <tr>
                            <td>{{ $record->parish->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->assigned_from)->format('Y-m-d') }}</td>
                            <td>
                                {{ $record->assigned_to
                                    ? \Carbon\Carbon::parse($record->assigned_to)->format('Y-m-d')
                                    : 'Present'
                                }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No assignment history available.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>
</div>

@stop
