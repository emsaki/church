@extends('adminlte::page')

@section('title', 'Parishes')

@section('content_header')
    <h1 class="font-weight-bold">Parish Management</h1>
@stop

@section('content')

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success shadow-sm">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

{{-- MAIN CARD --}}
<div class="card shadow-sm">

    {{-- Header --}}
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-church"></i> Parish List
        </h3>

        <a href="{{ route('admin.parishes.create') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-plus"></i> Add Parish
        </a>
    </div>

    {{-- BODY --}}
    <div class="card-body p-0">

        <table class="table table-hover table-striped mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Name</th>
                    <th>Priest(s)</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th class="text-right" width="160">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($parishes as $parish)
                    <tr>
                        <td class="align-middle">{{ $parish->name }}</td>

                        <td class="align-middle">
                            {{-- {{ $parish->priest?->full_name ?? '— Not Assigned —' }} --}}
                        
                            @php
                            $activePriests = $parish->activePriests;
                            @endphp

                            @if($activePriests->count())
                                @foreach($activePriests as $priest)
                                    <span class="badge badge-info mb-1">
                                        {{ $priest->full_name }}
                                    </span><br>
                                @endforeach
                            @else
                                <span class="text-muted">— No Active Priest —</span>
                            @endif
                        </td>
                        <td class="align-middle">{{ $parish->email }}</td>
                        <td class="align-middle">{{ $parish->phone }}</td>
                        <td class="align-middle">{{ $parish->location }}</td>

                        <td class="text-right">

                            {{-- View --}}
                            <a href="{{ route('admin.parishes.show', $parish) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('admin.parishes.edit', $parish) }}"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admin.parishes.destroy', $parish) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this parish?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <em>No parishes have been registered yet.</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>
</div>

@stop