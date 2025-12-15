@extends('adminlte::page')

@section('title', 'Approve Baptism')

@section('content')

<div class="container mt-4">

    <div class="card shadow-lg">

        {{-- Header --}}
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">
                Approve Baptism – {{ $record->member?->full_name ?? $record->full_name }}
            </h3>
        </div>

        <div class="card-body">

            <h4 class="text-secondary font-weight-bold mb-3">Baptism Approval Form</h4>

            <form action="{{ route('priest.baptisms.approve.save', $record->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label><strong>Certificate Number</strong> <span class="text-danger">*</span></label>
                    <input type="text" name="certificate_number" class="form-control" required>
                </div>

                <div class="form-group">
                    <label><strong>Baptism Date</strong> <span class="text-danger">*</span></label>
                    <input type="date" name="baptism_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label><strong>Notes (Optional)</strong></label>
                    <textarea name="notes" rows="3" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success btn-lg btn-block mt-3">
                    <i class="fas fa-check-circle"></i> Confirm Baptism
                </button>

            </form>

        </div>
    </div>

</div>

@endsection
