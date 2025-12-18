@extends('adminlte::page')
@section('title', 'User Management')
@section('content_header')
    <h1 class="font-weight-bold"><i class="fas fa-users-cog"></i> User Management</h1>
@stop
@section('content')
<a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">
    <i class="fas fa-user-plus"></i> Add User
</a>

<div class="card shadow">
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Status</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @foreach($u->roles as $role)
                            <span class="badge badge-info">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($u->active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.users.destroy', $u) }}" class="d-inline" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete user?')" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-3">
            {{ $users->links() }}
        </div>
    </div>
</div>

@stop