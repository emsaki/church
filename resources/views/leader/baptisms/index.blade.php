@extends('adminlte::page')

@section('title', 'Baptism Requests')

@section('content_header')
    <h1>Baptism Requests</h1>
@stop

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">My Baptism Requests</h3>

        <a href="{{ route('leader.baptisms.create', 0) }}"
           class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> New Baptism Request
        </a>
    </div>

    <div class="card-body">

        @if($records->isEmpty())
            <div class="alert alert-info text-center">
                No baptism records yet.
            </div>
        @else
        
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>Applicant</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Certificate</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $r)
                        <tr>
                            <td>
                                {{ $r->member?->full_name ?? $r->full_name }}
                            </td>

                            <td>
                                <span class="badge 
                                    @if($r->status == 'pending') badge-warning
                                    @elseif($r->status == 'approved') badge-success
                                    @elseif($r->status == 'baptized') badge-info
                                    @else badge-secondary
                                    @endif
                                ">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>

                            <td>{{ $r->created_at->format('d M Y') }}</td>

                            <td>
                                {{ $r->certificate_number ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif

    </div>
</div>

@stop
