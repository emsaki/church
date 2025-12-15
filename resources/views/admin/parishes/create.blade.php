@extends('adminlte::page')

@section('title', 'Add Parish')

@section('content_header')
    <h1 class="font-weight-bold">Add Parish</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- Main Card --}}
        <div class="card shadow-lg">

            {{-- Header --}}
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-church"></i> New Parish
                </h3>
            </div>

            {{-- Body --}}
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
                        <button class="btn btn-success">
                            <i class="fas fa-save"></i> Save Parish
                        </button>
                    </div>
                </form>
            </div>

        </div>

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