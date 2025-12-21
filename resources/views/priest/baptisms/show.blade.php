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
                    <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#approvalModal">
                        <i class="fas fa-check-circle"></i> Approve / Reject
                    </button>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Approval Modal --}}
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            {{-- Modal Header --}}
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="approvalModalLabel">
                    <i class="fas fa-check-circle"></i> Approve Baptism Request
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            {{-- Modal Body --}}
            <form method="POST" action="{{ route('priest.baptisms.approve', $record->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    {{-- Approval Status --}}
                    <div class="form-group">
                        <label class="font-weight-bold">Approval Status</label>
                        <select name="approval_status" class="form-control" required>
                            <option value="">Select…</option>
                            <option value="approved">Approve</option>
                            <option value="rejected">Reject</option>
                        </select>
                    </div>

                    {{-- Notes --}}
                    <div class="form-group">
                        <label class="font-weight-bold">Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Add remarks…"></textarea>
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Submit Approval
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
