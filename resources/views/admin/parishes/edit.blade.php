@extends('adminlte::page')

@section('title', 'Edit Parish')

@section('content_header')
    <h1 class="font-weight-bold">Edit Parish</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Main Card --}}
        <div class="card shadow-lg">

            {{-- Header --}}
            <div class="card-header bg-warning text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-edit"></i> Update Parish Information
                </h3>
            </div>

            {{-- Body --}}
            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the errors below:</strong>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.parishes.update', $parish) }}">
                    @csrf
                    @method('PUT')

                    {{-- Use the same form partial for consistency --}}
                    @include('admin.parishes.form')

                    {{-- Action Buttons --}}
                    <div class="text-right mt-4">

                        <a href="{{ route('admin.parishes.index') }}"
                           class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Parish
                        </button>

                    </div>
                </form>

            </div>

        </div>

    </div>
</div>

@stop
