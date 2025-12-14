@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Admin Dashboard</h1>
@stop

@section('content')
<div class="max-w-7xl mx-auto">

    <h2 class="text-2xl font-semibold mb-6">System Overview</h2>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">

        <x-stat-card label="Priests" :value="$priests" color="blue" />
        <x-stat-card label="Parishes" :value="$parishes" color="green" />
        <x-stat-card label="Communities" :value="$communities" color="purple" />
        <x-stat-card label="Members" :value="$members" color="indigo" />
        <x-stat-card label="SCC Leaders" :value="$leaders" color="red" />

    </div>

    <!-- RECENT MEMBERS -->
    <div class="bg-white shadow rounded p-6">
        <h3 class="text-xl font-semibold mb-4">Recent Members</h3>

        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Parish</th>
                    <th class="px-4 py-2">SCC</th>
                    <th class="px-4 py-2">Joined</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentMembers as $m)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $m->full_name }}</td>
                        <td class="px-4 py-2">{{ $m->parish->name }}</td>
                        <td class="px-4 py-2">{{ $m->community->name }}</td>
                        <td class="px-4 py-2">{{ $m->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@stop
