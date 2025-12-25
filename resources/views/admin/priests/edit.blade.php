@extends('adminlte::page')

@section('title', 'Edit Priest')

@section('content_header')
    <h1>Edit Priest</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.priests.update', $priest) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.priests.form')

            {{-- Action Buttons --}}
                    <div class="text-right mt-4">

                        <a href="{{ route('admin.priests.index') }}"
                           class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Priest
                        </button>

                    </div>
        </form>

    </div>
</div>

@stop