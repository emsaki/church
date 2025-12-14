@extends('adminlte::page')

@section('title', 'Approve Baptism')

@section('content_header')
    <h1>Approve Baptism</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('priest.baptisms.update', $record) }}">
        @csrf

        <p><strong>Member:</strong> {{ $record->member->first_name }} {{ $record->member->last_name }}</p>

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="approved">Approve</option>
            <option value="rejected">Reject</option>
        </select>

        <label>Certificate Number</label>
        <input type="text" name="certificate_number" class="form-control">

        <label>Baptism Date</label>
        <input type="date" name="baptism_date" class="form-control">

        <label>Baptism Parish</label>
        <select name="parish_id" class="form-control">
            @foreach($parishes as $parish)
                <option value="{{ $parish->id }}">{{ $parish->name }}</option>
            @endforeach
        </select>

        <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
            Save
        </button>
    </form>
@stop
