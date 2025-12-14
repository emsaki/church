@extends('adminlte::page')
@section('title', 'Member Profile')
@section('content_header')
    <h1>Member Profile</h1>
@stop

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- HEADER CARD --}}
        <div class="bg-white shadow rounded p-6 mb-6">

            <h2 class="text-2xl font-semibold text-gray-800 mb-1">
                {{ $member->full_name }}
            </h2>

            <p class="text-gray-600">
                <strong>Member ID:</strong> {{ $member->id }}
            </p>

            <p class="text-gray-600">
                <strong>Parish:</strong> {{ $member->parish->name }}
            </p>

            <p class="text-gray-600">
                <strong>SCC:</strong> {{ $member->community->name }}
            </p>

        </div>


        {{-- DETAILS CARD --}}
        <div class="bg-white shadow rounded p-6">

            <h3 class="text-xl font-semibold mb-4 text-gray-700">Personal Information</h3>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-gray-500">Gender</label>
                    <p class="font-medium">{{ $member->gender }}</p>
                </div>

                <div>
                    <label class="text-gray-500">Date of Birth</label>
                    <p class="font-medium">{{ $member->dob ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-gray-500">Phone</label>
                    <p class="font-medium">{{ $member->phone ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-gray-500">Email</label>
                    <p class="font-medium">{{ $member->email ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-gray-500">Baptised?</label>
                    <p class="font-medium">
                        {{ $member->is_baptised ? 'Yes' : 'No' }}
                    </p>
                </div>

                <div>
                    <label class="text-gray-500">Baptism Certificate No.</label>
                    <p class="font-medium">
                        {{ $member->baptism_certificate_no ?? '-' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- BUTTONS --}}
        <div class="mt-6 flex space-x-4">

            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('scc_leader'))
                <a href="{{ route('admin.members.edit', $member) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Edit Member
                </a>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <form action="{{ route('admin.members.destroy', $member) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this member?');">
                    @csrf
                    @method('DELETE')

                    <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Delete Member
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.members.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Back
            </a>
        </div>

    </div>
@stop
