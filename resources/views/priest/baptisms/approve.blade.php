@extends('adminlte::page')

@section('title', 'Approve Baptism')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-water"></i> Approve Baptism Request
    </h1>
@stop

@section('content')

<div class="card shadow-lg">

    {{-- CARD HEADER --}}
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-check-circle"></i> Baptism Approval Form
        </h3>
    </div>

    {{-- CARD BODY --}}
    <div class="card-body">

        {{-- APPLICANT DETAILS --}}
        <div class="alert alert-secondary">
            <strong><i class="fas fa-user"></i> Applicant:</strong>
            {{ $record->member?->full_name ?? $record->full_name }}

            @if($record->dob)
                <br>
                <strong><i class="fas fa-birthday-cake"></i> DOB:</strong>
                {{ $record->dob }}
            @endif
        </div>

        <form method="POST" action="{{ route('priest.baptisms.approve.save', $record) }}">
            @csrf
            @method('PUT')
            <div class="row">

                {{-- STATUS --}}
                <div class="col-md-12 mb-3">
                    <label class="font-weight-bold">
                        <i class="fas fa-info-circle"></i> Approval Status
                    </label>
                    <select name="status" class="form-control" required>
                        <option value="approved">Approve</option>
                        <option value="rejected">Reject</option>
                    </select>
                </div>

            </div>

            {{-- NOTES (optional) --}}
            <div class="mb-3">
                <label class="font-weight-bold">
                    <i class="fas fa-comment-dots"></i> Notes (Optional)
                </label>
                <textarea name="notes" rows="3" class="form-control"
                          placeholder="Additional remarks..."></textarea>
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="text-right mt-4">
                <button class="btn btn-success px-4 py-2">
                    <i class="fas fa-save"></i> Approve
                </button>
            </div>

        </form>
    </div>

</div>

@stop
