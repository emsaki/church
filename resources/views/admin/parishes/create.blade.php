@extends('adminlte::page')

@section('title', 'Add Parish')

@section('content_header')
    <h1 class="font-weight-bold text-primary">Add Parish</h1>
@stop

@section('content')

<div class="card shadow-lg">

    {{-- Header --}}
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="fas fa-church"></i> Parish Information
        </h4>
    </div>

    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the errors below:</strong>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.parishes.store') }}">
            @csrf

            @include('admin.parishes.form')

            <div class="text-right mt-3">
                <button class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Save Parish
                </button>
            </div>

        </form>

    </div>
</div>

@stop

@section('js')
<script>
    $('select[name="priest_id"]').select2({
        width: '100%',
        theme: 'bootstrap4',
        placeholder: 'Select a priest',
        allowClear: true
    });
</script>
@endsection
