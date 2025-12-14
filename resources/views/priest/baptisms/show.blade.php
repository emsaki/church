@extends('adminlte::page')

@section('title', 'Baptism Request Details')

@section('content_header')
    <h1>Baptism Request Details</h1>
@stop

@section('content')
<div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">
            <h3 class="text-lg font-bold mb-3">Applicant Information</h3>
            <p><strong>Name:</strong>
                {{ $record->member?->full_name ?? $record->full_name }}
            </p>
            @if($record->dob)
                <p><strong>Date of Birth:</strong> {{ $record->dob }}
                </p>
            @endif
            <p><strong>Father:</strong> {{ $record->father_name ?? '-' }}</p>
            <p><strong>Mother:</strong> {{ $record->mother_name ?? '-' }}</p>
            <hr class="my-4">
            <h3 class="text-lg font-bold mb-3">Request Details</h3>
            <p><strong>Status:</strong>
                <span class="px-2 py-1 bg-yellow-200 rounded">{{ ucfirst($record->status) }}</span>
            </p>
            <p><strong>Submitted by:</strong> {{ $record->submitter?->name }}
            </p>
            <p><strong>Notes:</strong> {{ $record->notes ?? '-' }}
            </p>
            <div class="mt-3">
                <a href="{{ route('priest.baptisms.approve', $record->id) }}"
                class="btn btn-primary btn-sm">
                    Approve Baptism
                </a>
            </div>
        </div>
    </div>
@stop