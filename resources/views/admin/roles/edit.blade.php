@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
<h1 class="font-weight-bold">Edit Role: {{ $role->name }}</h1>
@stop

@section('content')

<div class="card shadow">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Role Name</label>
                <input name="name" value="{{ $role->name }}" class="form-control" required>
            </div>
            <button class="btn btn-primary mt-3">Save Changes</button>

        </form>

    </div>
</div>

@stop