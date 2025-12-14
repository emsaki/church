@extends('adminlte::page')

@section('title', 'Edit Position')

@section('content_header')
    <h1>Edit Position</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.positions.update', $position) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Position Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required
                       value="{{ old('name', $position->name) }}">
            </div>

            <button class="btn btn-primary">Update</button>

            <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@stop