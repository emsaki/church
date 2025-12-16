@extends('adminlte::page')

@section('title', 'My SCC Tithes')

@section('content_header')
<h1 class="font-weight-bold text-primary">
    <i class="fas fa-donate"></i> SCC Tithe Records – {{ $leaderScc->name }}
</h1>
@stop

@section('content')

{{-- SUMMARY BOXES --}}
<div class="row mb-4">

    {{-- Total Tithes --}}
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($totals) }} Tsh</h3>
                <p>Total Tithes Collected</p>
            </div>
            <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
        </div>
    </div>

    {{-- Member Count --}}
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $members->count() }}</h3>
                <p>Members in SCC</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>

    {{-- Add New Button --}}
    <div class="col-md-4 text-right d-flex align-items-center justify-content-end">
        <a href="{{ route('leader.tithes.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Add New Tithe
        </a>
    </div>
</div>
{{-- TOP CONTRIBUTORS --}}
<div class="card mt-4 shadow">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">
            <i class="fas fa-crown"></i> Top Contributors
        </h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Total Given</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topContributors as $tc)
                    <tr>
                        <td>{{ $tc->member->full_name }}</td>
                        <td>{{ number_format($tc->total) }} Tsh</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center text-muted">No contributions yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MAIN TABLE --}}
<div class="card shadow-lg">

    <div class="card-header bg-primary text-white">
        <h3 class="card-title">
            <i class="fas fa-list"></i> Tithe Contributions List
        </h3>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped table-bordered">
            <thead class="bg-light">
                <tr>
                    <th>Member</th>
                    <th class="text-right">Amount</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th class="text-center" style="width: 120px;">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($tithes as $t)
                <tr>
                    <td>{{ $t->member->full_name }}</td>
                    <td class="text-right">{{ number_format($t->amount) }} Tsh</td>
                    <td>{{ \Carbon\Carbon::parse($t->tithe_date)->format('d M Y') }}</td>
                    <td>{{ $t->notes ?: '-' }}</td>
                    <td class="text-center">

                        {{-- Edit --}}
                        <a href="{{ route('leader.tithes.edit', $t) }}" 
                           class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('leader.tithes.destroy', $t) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this tithe record?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        <i class="fas fa-info-circle"></i> No tithes recorded yet.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</div>

@stop