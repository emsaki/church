@extends('adminlte::page')

@section('title', 'Add Priest')

@section('content_header')
    <h1>Add Priest</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.priests.store') }}" method="POST">
            @csrf
            @include('admin.priests.form')

            <button class="btn btn-primary">Save</button>
        </form>

    </div>
</div>

@stop