@extends('adminlte::page')

@section('title', 'Priest Dashboard')

@section('content_header')
    <h1 class="font-weight-bold">Priest Dashboard</h1>
@stop

@section('content')

<div class="row">

    {{-- STAT CARDS --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $parishes->count() }}</h3>
                <p>My Parishes</p>
            </div>
            <div class="icon"><i class="fas fa-church"></i></div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $sccCount }}</h3>
                <p>SCCs</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $memberCount }}</h3>
                <p>Total Members</p>
            </div>
            <div class="icon"><i class="fas fa-user-friends"></i></div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $baptised }}</h3>
                <p>Baptised Members</p>
            </div>
            <div class="icon"><i class="fas fa-cross"></i></div>
        </div>
    </div>

</div> {{-- end stats row --}}

{{-- PARISH LIST --}}
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">Parishes Under Your Care</h3>
    </div>
    <div class="card-body">

        @forelse($parishes as $parish)
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                <span class="font-weight-bold">{{ $parish->name }}</span>
                <a href="{{ route('admin.parishes.show', $parish) }}" class="btn btn-sm btn-outline-primary">
                    View
                </a>
            </div>
        @empty
            <p class="text-muted">No parishes assigned.</p>
        @endforelse

    </div>
</div>

{{-- QUICK LINKS --}}
<div class="row">

    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h4 class="font-weight-bold">View All Members</h4>
                <p class="text-muted">See all members registered under your parish.</p>
                <a href="{{ route('admin.members.index') }}" class="btn btn-primary">Go</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h4 class="font-weight-bold">View SCCs</h4>
                <p class="text-muted">See small Christian communities.</p>
                <a href="{{ route('admin.communities.index') }}" class="btn btn-info">Go</a>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h4 class="font-weight-bold">Mass Schedule</h4>
                <p class="text-muted">Manage or view upcoming Mass schedules.</p>
                <a href="#" class="btn btn-success">Open</a>
            </div>
        </div>
    </div>

</div>

@stop
