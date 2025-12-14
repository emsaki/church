@extends('adminlte::page')

@section('title', 'Assign SCC Leader')

@section('content_header')
    <h1>{!! "'Members of ' . $community->name" !!}</h1>
@stop

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.communities.index') }}"
           class="text-blue-600 hover:underline">&larr; Back to Communities</a>
    </div>

    <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-semibold mb-4">
            {{ $community->name }} ({{ $community->parish->name }})
        </h2>

        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Gender</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $m)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            {{ $m->first_name }} {{ $m->middle_name }} {{ $m->last_name }}
                        </td>
                        <td class="px-4 py-2">{{ ucfirst($m->gender) }}</td>
                        <td class="px-4 py-2">{{ $m->phone ?? '-' }}</td>

                        <td class="px-4 py-2">
                            <a href="{{ route('admin.members.edit', $m) }}"
                               class="text-blue-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-gray-500">
                            No members found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $members->links() }}
        </div>
    </div>

@stop