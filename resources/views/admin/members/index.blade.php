@extends('adminlte::page')

@section('title', 'Members')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-user-friends text-primary"></i> Members
    </h1>
@stop

@section('content')

{{-- ADD MEMBER BUTTON --}}
<div class="mb-3 text-right">
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i> Add Member
    </a>
</div>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success shadow-sm">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- FILTER CARD --}}
<div class="card shadow mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-filter text-secondary"></i> Filter Members</h5>
    </div>

    <div class="card-body">

        <form method="GET" class="row g-3">

            {{-- PARISH FILTER --}}
            <div class="col-md-4">
                <label class="form-label font-weight-bold">Parish</label>
                <select name="parish_id" class="form-control">
                    <option value="">-- All Parishes --</option>
                    @foreach($parishes as $p)
                        <option value="{{ $p->id }}" {{ request('parish_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- COMMUNITY FILTER --}}
            <div class="col-md-4">
                <label class="form-label font-weight-bold">Small Christian Community (SCC)</label>
                <select name="community_id" class="form-control">
                    <option value="">-- All SCCs --</option>
                    @foreach($communities as $c)
                        <option value="{{ $c->id }}" {{ request('community_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FILTER BUTTON --}}
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Apply Filters
                </button>
            </div>

        </form>

    </div>
</div>

{{-- MEMBERS TABLE --}}
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-list"></i> Member List</h5>
    </div>

    <div class="card-body p-0">

        <table class="table table-striped table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Parish</th>
                    <th>SCC</th>
                    <th>Phone</th>
                    <th>Baptised?</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->full_name }}</td>
                    <td>
                        <span class="badge bg-primary">{{ $member->parish->name }}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $member->community->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>{{ $member->phone }}</td>
                    <td>
                        @if($member->is_baptised)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-warning text-dark">No</span>
                        @endif
                    </td>
                    <td class="text-right">
                        {{-- <a href="{{ route('admin.tithes.create', $member) }}" 
                        class="btn btn-sm btn-success" title="Record Tithe">
                            <i class="fas fa-coins"></i>
                        </a> --}}

                        <a href="{{ route('admin.tithes.scc_member', $member->id) }}"
                        class="btn btn-sm btn-info">
                            <i class="fas fa-list"></i>
                        </a>

                        <a href="{{ route('admin.tithes.receipt', $member) }}" 
                        class="btn btn-sm btn-info">
                            <i class="fas fa-file-pdf"></i>
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('admin.members.edit', $member) }}"
                           class="btn btn-sm btn-warning mr-1">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- PROFILE --}}
                        <a href="{{ route('admin.members.profile', $member) }}"
                            class="btn btn-sm btn-info text-white mr-1">
                            <i class="fas fa-id-card"></i>
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.members.destroy', $member) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this member?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
