@extends('adminlte::page')

@section('title', 'Add Priest')

@section('content_header')
    <h1 class="font-weight-bold">Add New Priest</h1>
@stop

@section('content')

{{-- SUCCESS / ERROR MESSAGES --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>There were some validation errors:</strong>
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-tie"></i> Priest Information
        </h3>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.priests.store') }}" method="POST">
            @csrf

            @include('admin.priests.form')

            <div class="mt-4 text-right">
                <button class="btn btn-success">
                    <i class="fas fa-save"></i> Save Priest
                </button>
            </div>
        </form>

    </div>
</div>

@stop