@extends('adminlte::page')

@section('title', 'SCC Leader Dashboard')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-users-cog"></i> SCC Leader Dashboard
    </h1>
@stop

@section('content')

{{-- === STAT CARDS (Admin Dashboard Style) === --}}
<div class="row">

    {{-- SCC Name --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h4 class="font-weight-bold">{{ $scc?->name ?? 'N/A' }}</h4>
                <p>Your SCC</p>
            </div>
            <div class="icon"><i class="fas fa-church"></i></div>
        </div>
    </div>

    {{-- Total Members --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $membersCount }}</h3>
                <p>Total Members</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>

    {{-- New Members This Month --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $recentMembers->count() }}</h3>
                <p>New This Month</p>
            </div>
            <div class="icon"><i class="fas fa-user-plus"></i></div>
        </div>
    </div>

    {{-- Parish --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h4 class="font-weight-bold">{{ $scc?->parish?->name }}</h4>
                <p>Parish</p>
            </div>
            <div class="icon"><i class="fas fa-church"></i></div>
        </div>
    </div>

</div> {{-- end stats row --}}



{{-- === LEADERSHIP POSITIONS === --}}
<div class="card shadow-sm mt-4">
    <div class="card-header bg-secondary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-tie"></i> SCC Leadership Positions
        </h3>
    </div>

    <div class="card-body p-0">

        @if($positions->isEmpty())
            <p class="text-muted py-4 px-3">
                <i class="fas fa-info-circle"></i> No leaders assigned yet.
            </p>
        @else
            <table class="table table-striped table-bordered mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 220px">Position</th>
                        <th>Leader</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($positions as $p)
                        <tr>
                            <td>
                                <i class="fas fa-user-tag text-muted"></i>
                                {{ $p->position?->name }}
                            </td>
                            <td>
                                {{ $p->member?->full_name }}
                                <br>
                                <small class="text-muted">{{ $p->member?->phone }}</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
</div>



{{-- === QUICK ACTIONS === --}}
<div class="card shadow-sm mt-4">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-bolt"></i> Quick Actions
        </h3>
    </div>

    <div class="card-body">

        <div class="d-flex flex-wrap gap-2">

            {{-- Add Member --}}
            <a href="{{ route('leader.members.create') }}"
               class="btn btn-outline-primary">
                <i class="fas fa-user-plus"></i> Add New Member
            </a>

            {{-- View All Members --}}
            <a href="{{ route('leader.members.index') }}"
               class="btn btn-outline-success">
                <i class="fas fa-users"></i> View All Members
            </a>

            {{-- Manage Leaders --}}
            @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.communities.leader', ['community' => $scc?->id]) }}"
               class="btn btn-outline-warning">
                <i class="fas fa-user-shield"></i> Manage Leaders
            </a>
            @endif

        </div>

    </div>
</div>

@stop
