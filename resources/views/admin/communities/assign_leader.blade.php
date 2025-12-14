@extends('adminlte::page')

@section('title', 'Assign Leader')

@section('content_header')
    <h1>Assign SCC Leader — {{ $community->name }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.communities.leader.update', $community) }}">
            @csrf
            @if(auth()->user()->hasRole('admin'))
                <div class="form-group">
                    <select name="position_id" class="form-control" required>
                        <option value="">-- Select Position --</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}">{{ $pos->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Select Member</label>
                    <select name="member_id" class="form-control" required>
                        <option value="">-- Choose Leader --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->full_name }} ({{ $m->phone }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="form-group">
                    <input type="hidden" name="small_community_id" value="{{ $leaderSccId }}">
                </div>
            @endif
            <button class="btn btn-primary mt-3">Assign Leader</button>
        </form>

    </div>
</div>

@stop