@extends('adminlte::page')

@section('title', 'Assign SCC Leader')

@section('content_header')
    <h1>Select SCC for Leader Assignment</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SCC Name</th>
                    <th>Parish</th>
                    <th>Current Leader</th>
                    <th>Assign</th>
                </tr>
            </thead>

            <tbody>
            @foreach($communities as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->parish->name }}</td>
                    <td>
                        @if($c->currentLeader)
                            {{ $c->currentLeader->member->full_name }}
                            <br>
                            <small class="text-muted">{{ $c->currentLeader->member->phone }}</small>
                        @else
                            <span class="text-muted">No Leader</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.communities.leader', $c) }}"
                           class="btn btn-primary btn-sm">
                            Assign Leader
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>

@stop