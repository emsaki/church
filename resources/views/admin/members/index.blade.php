@extends('adminlte::page')

@section('title', 'Members')

@section('content_header')
    <h1>Members</h1>
@stop

@section('content')

<div class="mb-3 text-right">
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Member
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body p-0">
        <form method="GET" class="mb-4 flex space-x-4">
            <select name="parish_id" class="border p-2 rounded w-48">
                <option value="">-- Select Parish --</option>
                @foreach($parishes as $p)
                    <option value="{{ $p->id }}" {{ request('parish_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->name }}
                    </option>
                @endforeach
            </select>

            <select name="community_id" class="border p-2 rounded w-48">
                <option value="">-- Select SCC --</option>
                @foreach($communities as $c)
                    <option value="{{ $c->id }}" {{ request('community_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>

            <button class="px-4 py-2 bg-primary text-white rounded shadow-sm hover:bg-primary-dark">
                Filter
            </button>
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Parish</th>
                <th>SCC</th>
                <th>Phone</th>
                <th>Baptised?</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->full_name }}</td>
                    <td>{{ $member->parish->name }}</td>
                    <td>{{ $member->community->name ?? '-' }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ $member->is_baptised ? 'Yes' : 'No' }}</td>

                    <td class="text-right">
                        <a href="{{ route('admin.members.edit', $member) }}"
                           class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('admin.members.profile', $member) }}"
                            class="text-purple-600 hover:underline">Profile</a>
                        <form action="{{ route('admin.members.destroy', $member) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this member?')">
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