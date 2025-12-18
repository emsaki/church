@extends('adminlte::page')

@section('title', 'Record Tithe')

@section('content_header')
<h1 class="font-weight-bold text-primary">
    <i class="fas fa-donate"></i> Record Tithe for {{ $member->full_name }}
</h1>
@stop

@section('content')

<div class="card shadow-lg">

    {{-- HEADER --}}
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-hand-holding-usd"></i> Enter Tithe Contribution
        </h3>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error:</strong> Please correct the fields below.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.tithes.store') }}">
            @csrf

            <input type="hidden" name="member_id" value="{{ $member->id }}">

            {{-- MEMBER (display only) --}}
            <div class="form-group mb-4">
                <label class="font-weight-bold">
                    <i class="fas fa-user"></i> Member
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    value="{{ $member->full_name }} ({{ $member->phone }})" 
                    disabled>
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
                <textarea 
                    name="notes" 
                    rows="3" 
                    class="form-control"
                    placeholder="Optional notes..."></textarea>
            </div>

            {{-- SUBMIT --}}
            <div class="text-right">
                <button class="btn btn-success px-4 py-2">
                    <i class="fas fa-save"></i> Save Contribution
                </button>
            </div>

        </form>

    </div>
</div>

@stop