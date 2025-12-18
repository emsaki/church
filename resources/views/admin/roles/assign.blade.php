@extends('adminlte::page')

@section('title', 'Assign Role')

@section('content_header')
<h1>Assign Role to User</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

<form method="POST" action="{{ route('admin.roles.assign') }}">
    @csrf

    <div class="form-group">
        <label>User</label>
        <select name="user_id" class="form-control" required>
            <option value="">-- Select User --</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="role_id" class="form-control" required>
            <option value="">-- Select Role --</option>
            @foreach($roles as $r)
                <option value="{{ $r->id }}">{{ $r->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Assign Role</button>

</form>

    </div>
</div>

@stop