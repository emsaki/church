@extends('adminlte::page')

@section('title', 'Add Parish')

@section('content_header')
    <h1>Add Parish</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('admin.parishes.store') }}">
            @csrf

            @include('admin.parishes.form')

            <button class="btn btn-primary">Save Parish</button>
        </form>

    </div>
</div>

@stop