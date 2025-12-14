@extends('adminlte::page')

@section('title', 'Add Parish')

@section('content_header')
    <h1>Create Community (Jumuiya)</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.communities.store') }}">
            @csrf

            @include('admin.communities.form')

            <button class="btn btn-primary">Save</button>
        </form>

    </div>
</div>
@stop
