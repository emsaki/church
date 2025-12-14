@extends('adminlte::page')
@section('title', 'User Roles')
@section('content_header')
    <h1>Manage Roles for {{ $user->name }}</h1>
@stop

@section('content')
    <div class="bg-white shadow rounded p-6">
        <form method="POST" action="{{ route('admin.roles.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                @foreach($roles as $role)
                    <div class="flex items-center justify-between p-3 border rounded">
                        <span class="font-medium">
                            {{ ucfirst($role->name) }}
                        </span>

                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" name="roles[]"
                                   value="{{ $role->id }}"
                                   {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-300 peer-focus:ring-2 rounded-full peer
                                peer-checked:bg-blue-600 transition-all"></div>
                        </label>
                    </div>
                @endforeach

            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('admin.roles.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded mr-2">Cancel</a>

                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Changes
                </button>
            </div>

        </form>

    </div>
@stop