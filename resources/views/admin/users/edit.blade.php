@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
<h1 class="font-weight-bold text-primary">
    <i class="fas fa-user-edit"></i> Edit User Details
</h1>
@stop

@section('content')

<div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="fas fa-user-cog"></i> Update User Information
        </h4>
    </div>

    <div class="card-body">

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There were some problems with your submission:</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="row">

                {{-- NAME --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">
                        <i class="fas fa-user"></i> Full Name
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control" 
                        value="{{ old('name', $user->name) }}" 
                        required>
                </div>

                {{-- EMAIL --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control" 
                        value="{{ old('email', $user->email) }}">
                </div>

                {{-- PHONE --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">
                        <i class="fas fa-phone"></i> Phone
                    </label>
                    <input 
                        type="text" 
                        name="phone" 
                        class="form-control" 
                        value="{{ old('phone', $user->phone) }}">
                </div>

                {{-- ROLE --}}
                <div class="col-md-6 mb-3">
                    <label class="font-weight-bold">
                        <i class="fas fa-user-tag"></i> Role
                    </label>
                    <select name="role_id" class="form-control">
                        <option value="">— Select User Role —</option>
                        @foreach ($roles as $r)
                            <option value="{{ $r->id }}"
                                {{ $user->roles->contains('id', $r->id) ? 'selected' : '' }}>
                                {{ $r->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ACTIVE/INACTIVE --}}
                <div class="col-md-4 mb-3">
                    <label class="font-weight-bold">
                        <i class="fas fa-toggle-on"></i> Status
                    </label>
                    <select name="active" class="form-control">
                        <option value="1" {{ $user->active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$user->active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                {{-- SAVE BUTTON --}}
                <div class="col-md-12 text-right mt-4">
                    <button class="btn btn-success px-4">
                        <i class="fas fa-save"></i> Update User
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@stop
