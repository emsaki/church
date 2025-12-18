@extends('adminlte::page')

@section('title', 'SCC Members')

@section('content_header')
    <h1 class="font-weight-bold">
        Members of {{ $scc->name }} ({{ $scc->members->count() }} members)
    </h1>
@stop

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Member</th>
                    <th>Phone</th>
                    <th>Total Tithes</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($scc->members as $member)
                <tr>
                    <td>{{ $member->full_name }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>
                        {{ number_format($member->tithes->sum('amount'), 2) }}
                    </td>
                    <td>
                        <a href="{{ route('admin.tithes.scc_member', $member->id) }}"
                           class="btn btn-sm btn-primary">
                            <i class="fas fa-list"></i> View Tithes
                        </a>

                        <a href="{{ route('admin.tithes.create', ['member' => $member->id]) }}"
                           class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Capture Tithe
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@stop