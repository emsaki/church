@extends('adminlte::page')
@section('title', 'Roles')
@section('content_header')
<h1>Role Management</h1>
@stop

@section('content')

<a class="btn btn-primary mb-3" href="{{ route('admin.roles.create') }}">+ Add Role</a>
<a class="btn btn-secondary mb-3" href="{{ route('admin.roles.assign_form') }}">Assign Roles</a>

<div class="card">
    <div class="card-body">

<table class="table table-striped">
    <thead>
        <tr>
            <th>Role</th>
            <th>Number of Users</th>
            <th width="180">Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td>{{ $role->users_count }}</td>
            <td>
                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('admin.roles.destroy', $role) }}" class="d-inline" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

    </div>
</div>

@stop