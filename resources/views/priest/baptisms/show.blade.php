@extends('adminlte::page')

@section('title', 'Baptism Request Details')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg">

        {{-- Header --}}
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">
                Baptism Request Details – 
                {{ $record->member?->full_name ?? $record->full_name }}
            </h3>
        </div>

        <div class="card-body">

            {{-- Applicant Information --}}
            <h4 class="text-secondary font-weight-bold mb-3">Applicant Information</h4>

            <table class="table table-striped table-bordered mb-4">
                <tbody>
                    <tr>
                        <th width="30%">Name</th>
                        <td>{{ $record->member?->full_name ?? $record->full_name }}</td>
                    </tr>

                    @if($record->dob)
                    <tr>
                        <th>Date of Birth</th>
                        <td>{{ $record->dob }}</td>
                    </tr>
                    @endif

                    <tr>
                        <th>Father</th>
                        <td>{{ $record->father_name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Mother</th>
                        <td>{{ $record->mother_name ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Request Information --}}
            <h4 class="text-secondary font-weight-bold mb-3">Request Details</h4>

            <table class="table table-striped table-bordered mb-4">
                <tbody>
                    <tr>
                        <th width="30%">Status</th>
                        <td>
                            <span class="badge badge-warning text-dark px-3 py-2">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Submitted By</th>
                        <td>{{ $record->submitter?->name }}</td>
                    </tr>

                    <tr>
                        <th>Notes</th>
                        <td>{{ $record->notes ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Approve Button --}}
            @if($record->status === 'pending')
                <div class="text-right">
                    <a href="{{ route('priest.baptisms.approve', $record->id) }}"
                       class="btn btn-success btn-lg">
                        <i class="fas fa-check-circle"></i> Approve Baptism
                    </a>
                </div>
            @endif

        </div>
    </div>

</div>

@endsection
