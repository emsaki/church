@extends('adminlte::page')

@section('title', 'Priests')

@section('content_header')
    <h1 class="font-weight-bold">Priests</h1>
@stop

@section('content')

{{-- Add Priest Button --}}
<div class="mb-3 text-right">
    <a href="{{ route('admin.priests.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Priest
    </a>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

{{-- MAIN CARD --}}
<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-user-tie"></i> Registered Priests
        </h3>
    </div>

    <div class="card-body p-0">

        <table class="table table-striped table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th style="width:25%">Name</th>
                    <th style="width:15%">Phone</th>
                    <th style="width:20%">Email</th>
                    <th style="width:10%">Active</th>
                    <th style="width:20%" class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($priests as $priest)
                <tr>
                    <td class="align-middle">{{ $priest->full_name }}</td>
                    <td class="align-middle">{{ $priest->phone }}</td>
                    <td class="align-middle">{{ $priest->email }}</td>

                    <td class="align-middle">
                        @if($priest->active)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-danger">No</span>
                        @endif
                    </td>

                    <td class="text-right align-middle">

                        {{-- EDIT BUTTON --}}
                        <a href="{{ route('admin.priests.edit', $priest) }}"
                           class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        {{-- DELETE BUTTON --}}
                        <form action="{{ route('admin.priests.destroy', $priest) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this priest?');">
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
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-info-circle"></i> No priests found.
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>

</div>

@stop
