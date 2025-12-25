@extends('adminlte::page')

@section('title', $parish->name)

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-church text-primary"></i> {{ $parish->name }}
    </h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        {{-- CURRENT PRIEST CARD --}}
        <div class="card shadow mb-4">

            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user-tie"></i> Current Priest
                </h3>
            </div>

            <div class="card-body">
                <h4 class="mb-1">
                    {{-- {{ $parish->priest?->full_name ?? '— Not Assigned —' }} --}}
                    @php
                    $activePriests = $parish->activePriests;
                    @endphp

                    @if($activePriests->count())
                        @foreach($activePriests as $priest)
                            <span class="badge badge-info mb-1">
                                {{ $priest->full_name }}
                            </span><br>
                        @endforeach
                    @else
                        <span class="text-muted">— No Active Priest —</span>
                    @endif
                </h4>

                <p class="text-muted mb-0">
                    @if($parish->priest)
                        Assigned since: <strong>{{ $parish->priestAssignmentStart }}</strong>
                    @else
                        Use the parish edit page to assign a priest.
                    @endif
                </p>
            </div>

        </div>


        {{-- PRIEST ASSIGNMENT HISTORY --}}
        <div class="card shadow">

            <div class="card-header bg-secondary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-history"></i> Priest Assignment History
                </h3>
            </div>

            <div class="card-body p-0">

                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="40%">Priest</th>
                            <th width="30%">From</th>
                            <th width="30%">To</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($parish->priestHistory as $record)
                        <tr>
                            <td>{{ $record->priest->full_name }}</td>
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
                                No assignment history recorded.
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
