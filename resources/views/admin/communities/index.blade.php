@extends('adminlte::page')

@section('title', 'Small Communities')

@section('content_header')
    <h1 class="font-weight-bold">Small Christian Communities (Jumuiya)</h1>
@stop

@section('content')

{{-- TOP ACTION BAR --}}
<div class="mb-3 text-right">
    <a href="{{ route('admin.communities.create') }}" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus"></i> Add Community
    </a>
</div>

{{-- MAIN CARD --}}
<div class="card shadow-lg">

    {{-- CARD BODY --}}
    <div class="card-body p-0">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <table class="table table-hover table-striped mb-0">
            <thead class="bg-light">
                <tr class="text-left">
                    <th style="width: 60px;">#</th>
                    <th>Name</th>
                    <th>Parish</th>
                    <th>Leaders</th>
                    <th class="text-center" style="width:160px;">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($communities as $com)
                <tr>
                    <td>{{ $com->id }}</td>

                    <td class="font-weight-semibold">
                        {{ $com->name }}
                    </td>

                    <td>
                        <span class="text-secondary">{{ $com->parish->name }}</span>
                    </td>

                    {{-- CURRENT LEADERS --}}
                    <td>
                        @php
                            $activeLeaders = $com->leaderHistory->where('is_active', true);
                        @endphp

                        @if($activeLeaders->count())
                            @foreach($activeLeaders as $leader)
                                <div class="mb-2 p-2 border rounded bg-light">
                                    <strong class="text-dark">{{ $leader->position->name }}:</strong>
                                    <span>{{ $leader->member->full_name }}</span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-phone"></i> {{ $leader->member->phone }}
                                    </small>
                                </div>
                            @endforeach
                        @else
                            <span class="text-muted">No leaders assigned</span>
                        @endif
                    </td>

                    {{-- ACTION BUTTONS --}}
                    <td class="text-center">

                        <a href="{{ route('admin.communities.leader', $com) }}"
                           class="btn btn-sm btn-outline-primary mb-1">
                            <i class="fas fa-user-check"></i> Assign Leader
                        </a>

                        <br>

                        <a href="{{ route('admin.communities.edit', $com) }}"
                           class="btn btn-sm btn-warning mb-1">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.communities.destroy', $com) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this community?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>

                        </form>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        No communities found.
                    </td>
                </tr>
            @endforelse

            </tbody>
        </table>

    </div> {{-- end card-body --}}
</div> {{-- end card --}}

@stop