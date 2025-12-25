@extends('adminlte::page')

@section('title', 'Manage Assignments')

@section('content_header')
    <h1>Manage Parish Assignments – {{ $priest->full_name }}</h1>
@stop

@section('content')

{{-- SUCCESS --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">

    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Assign New Parish</h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('admin.priests.assign', $priest->id) }}">
            @csrf

            <div class="form-group">
                <label><strong>Select Parish</strong></label>
                <select name="parish_id" class="form-control" required>
                    <option value="">— Choose Parish —</option>
                    @foreach($parishes as $parish)
                        <option value="{{ $parish->id }}">{{ $parish->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success">
                <i class="fas fa-plus"></i> Assign Parish
            </button>

        </form>
    </div>

</div>


{{-- Assignment History --}}
<div class="card shadow mt-4">
    <div class="card-header bg-secondary text-white">
        <h3 class="card-title">Assignment History</h3>
    </div>

    <table class="table table-bordered mb-0">
        <thead>
            <tr>
                <th>Parish</th>
                <th>Assigned From</th>
                <th>Assigned To</th>
                <th width="120">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $h)
                <tr>
                    <td>{{ $h->parish->name }}</td>
                    <td>{{ $h->assigned_from }}</td>
                    <td>{{ $h->assigned_to ?? 'Active' }}</td>
                    <td>
                        @if(!$h->assigned_to)
                            <form method="POST"
                                  action="{{ route('admin.priests.remove.assignment', [$priest->id, $h->id]) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </form>
                        @else
                            <span class="text-muted">Closed</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@stop
