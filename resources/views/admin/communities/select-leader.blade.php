@extends('adminlte::page')

@section('title', 'Assign SCC Leader')

@section('content_header')
    <h1 class="font-weight-bold">Select SCC for Leader Assignment</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        {{-- MAIN CARD --}}
        <div class="card shadow-lg">

            {{-- HEADER --}}
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-users-cog"></i> Small Christian Communities (Jumuiya)
                </h3>
            </div>

            {{-- BODY --}}
            <div class="card-body p-0">

                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="25%">SCC Name</th>
                            <th width="25%">Parish</th>
                            <th width="30%">Current Leader</th>
                            <th width="20%" class="text-center">Assign</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($communities as $c)
                            <tr>
                                {{-- SCC NAME --}}
                                <td class="align-middle">
                                    <strong>{{ $c->name }}</strong>
                                </td>

                                {{-- PARISH --}}
                                <td class="align-middle text-secondary">
                                    {{ $c->parish->name }}
                                </td>

                                {{-- CURRENT LEADER --}}
                                <td class="align-middle">
                                    @if($c->currentLeader)
                                        <div>
                                            <strong>{{ $c->currentLeader->member->full_name }}</strong>
                                        </div>
                                        <small class="text-muted">
                                            {{ $c->currentLeader->member->phone }}
                                        </small>
                                    @else
                                        <span class="badge bg-secondary">No Leader Assigned</span>
                                    @endif
                                </td>

                                {{-- ASSIGN BUTTON --}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.communities.leader', $c) }}"
                                       class="btn btn-sm btn-success px-3">
                                        <i class="fas fa-user-plus"></i> Assign
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div> {{-- end body --}}
        </div> {{-- end card --}}

    </div>
</div>

@stop
