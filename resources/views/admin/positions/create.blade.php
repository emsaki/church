@extends('adminlte::page')

@section('title', 'Add Position')

@section('content_header')
    <h1>Add Position</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.positions.store') }}">
            @csrf

            <div class="form-group">
                <label>Position Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required
                       value="{{ old('name') }}">
            </div>

            <button class="btn btn-primary">Save</button>

            <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>
</div>

@stop