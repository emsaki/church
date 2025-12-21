@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1 class="font-weight-bold">Admin Dashboard</h1>
@stop

@section('content')

{{-- STAT CARDS --}}
<div class="row">

    <div class="col-lg-2 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $priests }}</h3>
                <p>Priests</p>
            </div>
            <div class="icon"><i class="fas fa-user-tie"></i></div>
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $parishes }}</h3>
                <p>Parishes</p>
            </div>
            <div class="icon"><i class="fas fa-church"></i></div>
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $communities }}</h3>
                <p>Communities</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $members }}</h3>
                <p>Members</p>
            </div>
            <div class="icon"><i class="fas fa-user-friends"></i></div>
        </div>
    </div>

    <div class="col-lg-2 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $leaders }}</h3>
                <p>SCC Leaders</p>
            </div>
            <div class="icon"><i class="fas fa-users-cog"></i></div>
        </div>
    </div>

</div> {{-- end stats row --}}

{{-- RECENT MEMBERS TABLE --}}
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">Recent Members</h3>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped table-bordered mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Parish</th>
                    <th>SCC</th>
                    <th>Joined</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentMembers as $m)
                    <tr>
                        <td>{{ $m->full_name }}</td>
                        <td>{{ $m->parish->name ?? '-' }}</td>
                        <td>{{ $m->community->name ?? '-' }}</td>
                        <td>{{ $m->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            No recent members found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@stop
