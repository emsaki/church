@extends('adminlte::page')

@section('title', 'Positions')

@section('content_header')
    <h1>Positions</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.positions.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Position
        </a>
    </div>

    <div class="card-body p-0">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th style="width: 60px">#</th>
                    <th>Name</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($positions as $pos)
                    <tr>
                        <td>{{ $pos->id }}</td>
                        <td>{{ $pos->name }}</td>
                        <td>
                            <a href="{{ route('admin.positions.edit', $pos) }}" 
                               class="btn btn-sm btn-info">
                                Edit
                            </a>

                            <form action="{{ route('admin.positions.destroy', $pos) }}"
                                  method="POST" style="display:inline-block;"
                                  onsubmit="return confirm('Delete position?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted p-3">
                            No positions found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@stop