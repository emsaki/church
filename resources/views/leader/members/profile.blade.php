@extends('adminlte::page')

@section('title', 'Member Profile')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-user text-primary"></i> Member Profile
    </h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        {{-- ========================= --}}
        {{-- HEADER CARD --}}
        {{-- ========================= --}}
        <div class="card shadow-lg mb-4">

            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-id-card-alt"></i> {{ $member->full_name }}
                </h3>
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted mb-1"><strong>Member ID:</strong></p>
                        <p class="h5">{{ $member->id }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="text-muted mb-1"><strong>Gender:</strong></p>
                        <p class="h5">{{ $member->gender ?? '-' }}</p>
                    </div>
                </div>

                <hr>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1"><strong>Parish:</strong></p>
                        <p class="h5">{{ $member->parish?->name }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1"><strong>Small Christian Community (SCC):</strong></p>
                        <p class="h5">{{ $member->community?->name ?? '-' }}</p>
                    </div>

                </div>

            </div>
        </div>


        {{-- ========================= --}}
        {{-- PERSONAL DETAILS CARD --}}
        {{-- ========================= --}}
        <div class="card shadow-lg mb-4">

            <div class="card-header bg-secondary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user-circle"></i> Personal Information
                </h3>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Date of Birth</label>
                        <p class="font-weight-bold">{{ $member->dob ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Phone</label>
                        <p class="font-weight-bold">{{ $member->phone ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Email</label>
                        <p class="font-weight-bold">{{ $member->email ?? '-' }}</p>
                    </div>

                </div>
            </div>
        </div>


        {{-- ========================= --}}
        {{-- BAPTISM DETAILS CARD --}}
        {{-- ========================= --}}
        <div class="card shadow-lg mb-4">

            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-baby"></i> Baptism Information
                </h3>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="text-muted">Baptised?</label>
                        <p class="font-weight-bold">
                            {{ $member->is_baptised ? 'Yes' : 'No' }}
                        </p>
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="text-muted">Baptism Certificate No.</label>
                        <p class="font-weight-bold">
                            {{ $member->baptism_certificate_no ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>
        </div>


        {{-- ========================= --}}
        {{-- BUTTONS --}}
        {{-- ========================= --}}
        <div class="d-flex justify-content-end gap-2">

            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('scc_leader'))
                <a href="{{ route('admin.members.edit', $member) }}"
                   class="btn btn-primary mr-2">
                    <i class="fas fa-edit"></i> Edit Member
                </a>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <form action="{{ route('admin.members.destroy', $member) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this member?');">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            @endif

        </div>

    </div>
</div>

@stop
