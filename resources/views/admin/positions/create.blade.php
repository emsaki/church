@extends('adminlte::page')

@section('title', 'Add Position')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-plus-circle text-primary"></i> Add Position
    </h1>
@stop

@section('content')

<div class="card shadow-lg mt-3">

    {{-- HEADER --}}
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-briefcase"></i> Create New Position
        </h3>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the errors below:</strong>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.positions.store') }}">
            @csrf

            {{-- Position Name --}}
            <div class="form-group">
                <label class="font-weight-bold">Position Name <span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Enter position name"
                    required
                    value="{{ old('name') }}"
                >

                {{-- Error Message --}}
                @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="mt-4 d-flex">

                <button class="btn btn-success mr-2">
                    <i class="fas fa-save"></i> Save Position
                </button>

                <a href="{{ route('admin.positions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>

            </div>

        </form>

    </div>
</div>

@stop
