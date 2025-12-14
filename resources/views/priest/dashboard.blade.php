@extends('adminlte::page')
@section('title', 'Priest Dashboard')
@section('content_header')
    <h1>Priest Dashboard</h1>
@stop

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-6">

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <x-stat-card label="My Parishes" value="{{ $parishes->count() }}" color="purple" />
                <x-stat-card label="SCCs" value="{{ $sccCount }}" color="blue" />
                <x-stat-card label="Members" value="{{ $memberCount }}" color="green" />
                <x-stat-card label="Baptised Members" value="{{ $baptised }}" color="yellow" />
            </div>

            {{-- PARISH LIST --}}
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Parishes Under Your Care</h3>

                @forelse($parishes as $parish)
                    <div class="border-b py-3">
                        <a href="{{ route('admin.parishes.show', $parish) }}"
                           class="text-blue-600 hover:underline">
                            {{ $parish->name }}
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500">No parishes assigned.</p>
                @endforelse
            </div>

            {{-- QUICK LINKS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <a href="{{ route('admin.members.index') }}"
                   class="block p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                    <h3 class="text-lg font-bold mb-2">View All Members</h3>
                    <p class="text-gray-600">See all parish members.</p>
                </a>

                <a href="{{ route('admin.communities.index') }}"
                   class="block p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                    <h3 class="text-lg font-bold mb-2">View SCCs</h3>
                    <p class="text-gray-600">Check small communities.</p>
                </a>

                <a href="#" class="block p-6 bg-white shadow rounded-lg hover:bg-gray-50">
                    <h3 class="text-lg font-bold mb-2">Mass Schedule</h3>
                    <p class="text-gray-600">Manage or view your Mass schedules.</p>
                </a>

            </div>

        </div>
    </div>

@stop
