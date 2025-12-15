@extends('adminlte::page')

@section('title', 'Create Community')

@section('content_header')
    <h1 class="font-weight-bold">Create Community (Jumuiya)</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">

        {{-- MAIN CARD --}}
        <div class="card shadow-lg">

            {{-- Card Header --}}
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-users"></i> New Small Christian Community
                </h3>
            </div>

            {{-- Form Body --}}
            <div class="card-body">

                {{-- Validation --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        Please correct the highlighted errors.
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.communities.store') }}">
                    @csrf

                    @include('admin.communities.form')

                    <div class="text-right mt-4">
                        <a href="{{ route('admin.communities.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>

                        <button class="btn btn-success px-4">
                            <i class="fas fa-save"></i> Save Community
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>

@stop
