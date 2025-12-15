@extends('adminlte::page')

@section('title', 'Assign Leader')

@section('content_header')
    <h1 class="font-weight-bold">
        Assign SCC Leader — {{ $community->name }}
    </h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- MAIN CARD --}}
        <div class="card shadow-lg">

            {{-- Header --}}
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user-check"></i> Assign Leader to {{ $community->name }}
                </h3>
            </div>

            {{-- Body --}}
            <div class="card-body">

                {{-- Success / Errors --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please correct the errors below.</strong>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.communities.leader.update', $community) }}">
                    @csrf

                    @if(auth()->user()->hasRole('admin'))

                        {{-- POSITION SELECTION --}}
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Select Leadership Position</label>
                            <select name="position_id"
                                    class="form-control @error('position_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Select Position --</option>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}">
                                        {{ $pos->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('position_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- MEMBER SELECTION --}}
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Select Member</label>
                            <select name="member_id"
                                    class="form-control @error('member_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Choose Leader --</option>
                                @foreach($members as $m)
                                    <option value="{{ $m->id }}">
                                        {{ $m->full_name }} — {{ $m->phone }}
                                    </option>
                                @endforeach
                            </select>

                            @error('member_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    @else
                        {{-- For SCC Leader users: locked SCC assignment --}}
                        <input type="hidden" name="small_community_id" value="{{ $leaderSccId }}">

                        <div class="alert alert-info">
                            You are assigning a leader within your SCC only.
                        </div>
                    @endif

                    {{-- ACTION BUTTON --}}
                    <div class="text-right">
                        <button class="btn btn-success px-4">
                            <i class="fas fa-save"></i> Assign Leader
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

@stop
