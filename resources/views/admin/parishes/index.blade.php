@extends('adminlte::page')

@section('title', 'Parishes')

@section('content_header')
    <h1>Parish Management</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.parishes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Parish
        </a>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Priest</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Location</th>
                <th width="120"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($parishes as $parish)
                <tr>
                    <td>{{ $parish->name }}</td>
                    {{-- <td>{{ $parish->priest_name }}</td> --}}
                    <td>{{ $parish->priest?->full_name ?? 'No priest assigned' }}</td>
                    <td>{{ $parish->email }}</td>
                    <td>{{ $parish->phone }}</td>
                    <td>{{ $parish->location }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.parishes.edit', $parish) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('admin.parishes.show', $parish) }}" class="btn btn-sm btn-info">View</a>

                        <form action="{{ route('admin.parishes.destroy', $parish) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this parish?')">
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