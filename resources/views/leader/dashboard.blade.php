@extends('adminlte::page')

@section('title', 'SCC Leader Dashboard')

@section('content_header')
    <h1>SCC Leader Dashboard</h1>
@stop

@section('content')
<div class="max-w-6xl mx-auto">

    <h2 class="text-2xl font-semibold mb-6">
        Welcome, SCC Leader ({{ auth()->user()->name }})
    </h2>

    <!-- SCC SUMMARY -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-gray-600 text-sm">Your SCC</h3>
            <p class="text-xl font-bold">{{ $scc?->name }}</p>
            <p class="text-gray-500 text-sm">Parish: {{ $scc?->parish->name }}</p>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-gray-600 text-sm">Total Members</h3>
            <p class="text-3xl font-bold text-blue-600">{{ $membersCount }}</p>
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-gray-600 text-sm">New Members This Month</h3>
            <p class="text-3xl font-bold text-green-600">{{ $recentMembers?->count() }}</p>
        </div>

    </div>

    <!-- POSITIONS -->
    <div class="bg-white shadow rounded p-6 mb-6">

        <h3 class="text-xl font-semibold mb-4">Leadership Positions</h3>

        @if($positions?->isEmpty())
            <p class="text-gray-500">No leaders assigned yet.</p>
        @else
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Position</th>
                    <th class="px-4 py-2">Member</th>
                </tr>
            </thead>
            <tbody>
                @if($positions)
                    @foreach($positions as $p)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $p->position?->name }}</td>
                            <td class="px-4 py-2">{{ $p->member?->full_name }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @endif
    </div>

    <!-- QUICK ACTIONS -->
    <div class="bg-white shadow rounded p-6">
        <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>

        <div class="space-x-4">
            <a href="{{ route('leader.members.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Add New Member
            </a>

            <a href="{{ route('leader.members.index') }}"
               class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                View All Members
            </a>

            <a href="{{ route('admin.communities.leader', ['community' => $scc?->id]) }}"
                class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                Manage Leaders
            </a>
        </div>
    </div>

</div>

@stop
