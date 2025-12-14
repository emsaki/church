@extends('adminlte::page')

@section('title', 'User Roles')

@section('content_header')
    <h1>User Role Management</h1>
@stop

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            @forelse($user->roles as $role)
                                <span class="badge bg-primary">{{ strtoupper($role->name) }}</span>
                            @empty
                                <span class="text-muted">None</span>
                            @endforelse
                        </td>

                        <td>
                            <a href="{{ route('admin.roles.edit', $user) }}"
                               class="btn btn-sm btn-primary">
                               Manage
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop