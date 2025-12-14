@extends('adminlte::page')

@section('title', 'Small Communities')

@section('content_header')
    <h1>Small Christian Communities (Jumuiya)</h1>
@stop

@section('content')

<div class="mb-3 text-right">
    <a href="{{ route('admin.communities.create') }}"
       class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Community
    </a>
</div>

<div class="card">
    <div class="card-body p-0">

        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Parish</th>
                <th>Leader</th>
                <th width="150">Actions</th>
            </tr>
            </thead>

            <tbody>
            @forelse($communities as $com)
                <tr>
                    <td>{{ $com->id }}</td>
                    <td>{{ $com->name }}</td>
                    <td>{{ $com->parish->name }}</td>
                    <td class="px-4 py-2">
                        @forelse($com->leaderHistory->where('is_active', true) as $leader)
                            <strong>{{ $leader->position->name }}:</strong>
                            {{ $leader->member->full_name }} <br>
                            <small class="text-gray-500">{{ $leader->member->phone }}</small>
                            <br>
                        @empty
                            <span class="text-gray-500">No leaders assigned</span>
                        @endforelse
                    </td>

                    <td class="px-4 py-2">
                        <a href="{{ route('admin.communities.leader', $com) }}"
                        class="text-blue-600 hover:underline mr-3">Assign Leader</a>
                    </td>

                    <td>
                        <a href="{{ route('admin.communities.edit', $com) }}"
                           class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('admin.communities.destroy', $com) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this community?')">
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
                    <td colspan="5" class="text-center text-muted p-4">
                        No communities found.
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

@stop