@extends('adminlte::page')

@section('title', 'Priests')

@section('content_header')
    <h1>Priests</h1>
@stop

@section('content')

<div class="text-right mb-3">
    <a href="{{ route('admin.priests.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Priest
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Active?</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($priests as $priest)
                <tr>
                    <td>{{ $priest->full_name }}</td>
                    <td>{{ $priest->phone }}</td>
                    <td>{{ $priest->email }}</td>
                    <td>{{ $priest->active ? 'Yes' : 'No' }}</td>

                    <td class="text-right">
                        <a href="{{ route('admin.priests.edit', $priest) }}"
                           class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('admin.priests.destroy', $priest) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this priest?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
</div>

@stop