@extends('adminlte::page')

@section('title', 'Baptism Requests – Priest Panel')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-baby"></i> Baptism Requests (Priest Panel)
    </h1>
@stop

@section('content')

<div class="card shadow-lg">

    {{-- CARD HEADER --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-water"></i> Baptism Requests
        </h3>
    </div>

    {{-- CARD BODY --}}
    <div class="card-body">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered mb-0">
                <thead class="bg-light">
                    <tr>
                        <th><i class="fas fa-user"></i> Applicant</th>
                        <th><i class="fas fa-user-edit"></i> Submitted By</th>
                        <th><i class="fas fa-info-circle"></i> Status</th>
                        <th style="width: 120px;"><i class="fas fa-cogs"></i> Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($records as $record)
                    <tr>
                        {{-- Applicant --}}
                        <td class="align-middle">
                            <strong>{{ $record->member?->full_name ?? $record->full_name }}</strong>
                            @if($record->dob)
                                <br><small class="text-muted">DOB: {{ $record->dob }}</small>
                            @endif
                        </td>

                        {{-- Submitted By --}}
                        <td class="align-middle">
                            {{ $record->submitter?->name }}
                            <br>
                            <small class="text-muted">{{ $record->created_at->format('d M Y') }}</small>
                        </td>

                        {{-- Status --}}
                        <td class="align-middle">
                            @php
                                $badge = [
                                    'pending'  => 'warning',
                                    'approved' => 'success',
                                    'baptized' => 'info',
                                    'rejected' => 'danger',
                                ][$record->status] ?? 'secondary';
                            @endphp

                            <span class="badge bg-{{ $badge }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>

                        {{-- Action --}}
                        <td class="align-middle text-center">
                            <a href="{{ route('priest.baptisms.show', $record) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle"></i> No baptism requests found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@stop
