@extends('adminlte::page')

@section('title', 'Approve Baptism')

@section('content_header')
    <h1>Approve Baptism – {{ $record->member?->full_name ?? $record->full_name }}</h1>
@stop

@section('content')
<div class="py-6">
    <div class="max-w-6xl mx-auto bg-white shadow p-6 rounded">

        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">Baptism Approval Form</h3>
            </div>

            <div class="card-body">

                <form action="{{ route('priest.baptisms.approve.save', $record) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="certificate_number">Certificate Number <span class="text-danger">*</span></label>
                        <input type="text" name="certificate_number" id="certificate_number"
                               class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="baptism_date">Baptism Date <span class="text-danger">*</span></label>
                        <input type="date" name="baptism_date" id="baptism_date"
                               class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-check-circle"></i> Confirm Baptism
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>
@stop