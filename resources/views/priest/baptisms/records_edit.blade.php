@extends('adminlte::page')

@section('title', 'Update Baptism Record')

@section('content')

<div class="card shadow-lg mt-4">

    <div class="card-header bg-primary text-white">
        <h3><i class="fas fa-edit"></i> Update Baptism Record</h3>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('priest.baptisms.records.update', $record->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Baptism Date</label>
                <input type="date" name="baptism_date" class="form-control"
                       value="{{ $record->baptism_date }}" required>
            </div>

            <div class="form-group">
                <label>Certificate Number</label>
                <input type="text" name="certificate_number" class="form-control"
                       value="{{ $record->certificate_number }}">
            </div>

            {{-- <div class="form-group">
                <label>Baptism Parish</label>
                <input type="text" name="parish_id" class="form-control"
                       value="{{ $record->parish->id }}" required>
            </div> --}}

            {{-- <div class="form-group">
                <label>Minister Name</label>
                <input type="text" name="minister_name" class="form-control"
                       value="{{ $record->minister_name }}">
            </div> --}}

            {{-- <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" class="form-control" rows="3">{{ $record->notes }}</textarea>
            </div> --}}

            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-save"></i> Save Changes
            </button>

        </form>

    </div>

</div>

@endsection