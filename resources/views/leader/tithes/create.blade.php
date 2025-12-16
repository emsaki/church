@extends('adminlte::page')

@section('title', 'Record Tithe')

@section('content_header')
<h1 class="font-weight-bold text-primary">
    <i class="fas fa-donate"></i> Record Tithe
</h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-hand-holding-usd"></i> Enter Tithe Contribution
        </h3>
    </div>

    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error:</strong> Please correct the fields below.
            </div>
        @endif

        <form method="POST" action="{{ route('leader.tithes.store') }}">
            @csrf

            {{-- MEMBER --}}
            <div class="form-group mb-4">
                <label class="font-weight-bold">
                    <i class="fas fa-user"></i> Member
                </label>
                <select name="member_id" class="form-control" required>
                    <option value="">— Select Member —</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->full_name }} ({{ $member->phone }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- AMOUNT --}}
            <div class="form-group mb-4">
                <label class="font-weight-bold">
                    <i class="fas fa-money-bill-wave"></i> Amount (TZS)
                </label>
                <input 
                    type="number" 
                    name="amount" 
                    class="form-control" 
                    placeholder="Enter amount" 
                    required 
                    min="100">
            </div>

            {{-- DATE --}}
            <div class="form-group mb-4">
                <label class="font-weight-bold">
                    <i class="fas fa-calendar-alt"></i> Payment Date
                </label>
                <input type="date" name="tithe_date" class="form-control" required>
            </div>

            {{-- NOTES --}}
            <div class="form-group mb-4">
                <label class="font-weight-bold">
                    <i class="fas fa-comment-alt"></i> Notes (optional)
                </label>
                <textarea name="notes" rows="3" class="form-control"></textarea>
            </div>

            <div class="text-right">
                <button class="btn btn-success px-4 py-2">
                    <i class="fas fa-save"></i> Save Contribution
                </button>
            </div>

        </form>

    </div>
</div>

@stop