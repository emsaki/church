@extends('adminlte::page')

@section('title', 'Create Role')

@section('content_header')
<h1 class="font-weight-bold">Create New Role</h1>
@stop

@section('content')

<div class="card shadow">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf

            <div class="form-group">
                <label>Role Name</label>
                <input name="name" class="form-control" required>
            </div>
            <button class="btn btn-success mt-3">Save Role</button>

        </form>

    </div>
</div>

@stop