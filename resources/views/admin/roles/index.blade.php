@extends('adminlte::page')

@section('title', 'User Roles')

@section('content_header')
    <h1 class="font-weight-bold">User Role Management</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- MAIN CARD --}}
        <div class="card shadow-lg">

            {{-- HEADER --}}
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user-shield"></i> User & Role Overview
                </h3>
            </div>

            {{-- TABLE --}}
            <div class="card-body p-0">

                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Assigned Roles</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                {{-- USER NAME --}}
                                <td class="align-middle">
                                    <strong>{{ $user->name }}</strong>
                                </td>

                                {{-- EMAIL --}}
                                <td class="align-middle">
                                    <span class="text-secondary">{{ $user->email }}</span>
                                </td>

                                {{-- ROLES --}}
                                <td class="align-middle">
                                    @forelse($user->roles as $role)
                                        <span class="badge bg-primary px-3 py-1">
                                            {{ strtoupper($role->name) }}
                                        </span>
                                    @empty
                                        <span class="badge bg-secondary px-3 py-1">No Roles</span>
                                    @endforelse
                                </td>

                                {{-- MANAGE BUTTON --}}
                                <td class="align-middle text-center">
                                    <a href="{{ route('admin.roles.edit', $user) }}"
                                       class="btn btn-sm btn-success px-3">
                                        <i class="fas fa-edit"></i> Manage
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div> {{-- end table wrapper --}}
        </div> {{-- end card --}}
    </div>
</div>

@stop
