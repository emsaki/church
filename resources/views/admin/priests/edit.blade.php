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

            <button class="btn btn-primary">Update</button>
        </form>

    </div>
</div>

@stop