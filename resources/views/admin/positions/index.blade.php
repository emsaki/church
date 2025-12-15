@extends('adminlte::page')

@section('title', 'Positions')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-briefcase"></i> Positions
    </h1>
@stop

@section('content')

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif


<div class="card shadow-lg">

    {{-- CARD HEADER --}}
    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-list"></i> All Positions
        </h3>

        <a href="{{ route('admin.positions.create') }}" class="btn btn-secondary text-primary font-weight-bold">
            <i class="fas fa-plus-circle"></i> Add Position
        </a>
    </div>

    {{-- CARD BODY --}}
    <div class="card-body p-0">

        <table class="table table-hover table-striped mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width: 60px">#</th>
                    <th>Position Name</th>
                    <th class="text-right" style="width: 180px">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($positions as $pos)
                    <tr>
                        <td class="font-weight-bold">{{ $pos->id }}</td>
                        <td>{{ $pos->name }}</td>

                        <td class="text-right">

                            {{-- EDIT BUTTON --}}
                            <a href="{{ route('admin.positions.edit', $pos) }}"
                               class="btn btn-sm btn-warning mr-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            {{-- DELETE BUTTON --}}
                            <form action="{{ route('admin.positions.destroy', $pos) }}"
                                  method="POST" class="d-inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this position?');">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="fas fa-info-circle"></i> No positions found.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

</div>

@stop
