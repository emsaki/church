@extends('adminlte::page')

@section('title', 'Baptism Requests')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-baby"></i> Baptism Requests
    </h1>
@stop

@section('content')

<div class="card shadow-sm">

    {{-- HEADER --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-list-alt"></i> My Baptism Requests
        </h3>

        <a href="{{ route('leader.baptisms.create', 0) }}"
           class="btn btn-secondary btn-sm">
            <i class="fas fa-plus"></i> New Baptism Request
        </a>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        @if($records->isEmpty())

            <div class="alert alert-info text-center py-4">
                <i class="fas fa-info-circle"></i> 
                No baptism requests found.
            </div>

        @else

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Applicant</th>
                        <th>Status</th>
                        <th>Submitted On</th>
                        <th>Certificate No.</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($records as $r)
                        <tr>
                            <td class="align-middle">
                                <strong>{{ $r->member?->full_name ?? $r->full_name }}</strong>
                            </td>

                            <td class="align-middle">
                                @php
                                    $badgeClass = match($r->status) {
                                        'pending' => 'badge-warning',
                                        'approved' => 'badge-success',
                                        'baptized' => 'badge-info',
                                        default => 'badge-secondary'
                                    };
                                @endphp

                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>

                            <td class="align-middle">
                                {{ $r->created_at->format('d M Y') }}
                            </td>

                            <td class="align-middle">
                                {{ $r->certificate_number ?: '—' }}
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
