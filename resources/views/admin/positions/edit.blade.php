@extends('adminlte::page')

@section('title', 'Edit Position')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-edit"></i> Edit Position
    </h1>
@stop

@section('content')

<div class="card shadow mt-3 border-0">

    {{-- Card Header --}}
    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-tag"></i> Update Position Details
        </h3>

        <a href="{{ route('admin.positions.index') }}" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- Card Body --}}
    <div class="card-body">

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>
                    <i class="fas fa-exclamation-triangle"></i> Please correct the errors below.
                </strong>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.positions.update', $position) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">

                    {{-- Position Name --}}
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Position Name <span class="text-danger">*</span></label>

                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-tag"></i>
                            </span>

                            <input 
                                type="text" 
                                name="name" 
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter position name"
                                required
                                value="{{ old('name', $position->name) }}"
                            >
                        </div>

                        @error('name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-4 d-flex">

                <button class="btn btn-success mr-2 px-4">
                    <i class="fas fa-save"></i> Update Position
                </button>

                <a href="{{ route('admin.positions.index') }}" 
                   class="btn btn-secondary px-4">
                    <i class="fas fa-times"></i> Cancel
                </a>

            </div>

        </form>

    </div> {{-- end card-body --}}
</div>

@stop
