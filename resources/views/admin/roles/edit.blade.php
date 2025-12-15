@extends('adminlte::page')

@section('title', 'Manage Roles')

@section('content_header')
    <h1 class="font-weight-bold">Manage Roles for {{ $user->name }}</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        {{-- MAIN CARD --}}
        <div class="card shadow-lg">

            {{-- HEADER --}}
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user-shield"></i> Role Assignment Panel
                </h3>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                <form method="POST" action="{{ route('admin.roles.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <p class="text-muted mb-4">
                        Toggle the roles below to assign or remove permissions for this user.
                    </p>

                    {{-- ROLE SWITCHES --}}
                    <div class="list-group">

                        @foreach($roles as $role)
                            <div class="list-group-item d-flex align-items-center justify-content-between">

                                {{-- ROLE NAME --}}
                                <span class="font-weight-bold text-secondary">
                                    {{ ucfirst($role->name) }}
                                </span>

                                {{-- BEAUTIFUL SWITCH --}}
                                <label class="switch mb-0">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                        {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>

                            </div>
                        @endforeach

                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="text-right mt-4">

                        <a href="{{ route('admin.roles.index') }}"
                           class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save"></i> Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

@stop


{{-- SWITCH STYLING --}}
@section('css')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        background-color: #ccc;
        border-radius: 34px;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #28a745; /* green */
    }

    input:checked + .slider:before {
        transform: translateX(24px);
    }

    .slider.round {
        border-radius: 34px;
    }
</style>
@stop
