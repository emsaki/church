@extends('adminlte::page')

@section('title', 'Edit Tithe')

@section('content_header')
    <h1 class="text-primary font-weight-bold">
        <i class="fas fa-edit"></i> Edit Tithe Record
    </h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-hand-holding-usd"></i> Edit Tithe Entry
        </h3>
    </div>

    <div class="card-body">

        <form action="{{ route('leader.tithes.update', $tithe->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- MEMBER --}}
            <div class="form-group">
                <label class="font-weight-bold">Member</label>
                <select name="member_id" class="form-control" required>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}"
                            {{ $tithe->member_id == $member->id ? 'selected' : '' }}>
                            {{ $member->full_name }} ({{ $member->phone }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- AMOUNT --}}
            <div class="form-group">
                <label class="font-weight-bold">Amount</label>
                <input type="number" name="amount" min="100" step="100"
                       class="form-control" value="{{ $tithe->amount }}" required>
            </div>

            {{-- DATE --}}
            <div class="form-group">
                <label class="font-weight-bold">Tithe Date</label>
                <input type="date" name="tithe_date" class="form-control"
                       value="{{ $tithe->tithe_date }}" required>
            </div>

            {{-- NOTES --}}
            <div class="form-group">
                <label class="font-weight-bold">Notes (optional)</label>
                <textarea name="notes" class="form-control" rows="3">{{ $tithe->notes }}</textarea>
            </div>

            <button class="btn btn-success btn-lg">
                <i class="fas fa-save"></i> Update Tithe
            </button>

        </form>

    </div>
</div>

@stop
