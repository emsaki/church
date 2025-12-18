@extends('adminlte::page')
@section('title', 'Add User')
@section('content_header')
<h1 class="font-weight-bold">Add New User</h1>
@stop

@section('content')
<div class="card shadow">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input name="phone" class="form-control">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Assign Roles</label>
                <select name="role_id" class="form-control">
                    @foreach($roles as $r)
                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success px-4">
                <i class="fas fa-save"></i> Save
            </button>
        </form>

    </div>
</div>

@stop
