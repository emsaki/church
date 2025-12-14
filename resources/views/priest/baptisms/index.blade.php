@extends('adminlte::page')

@section('title', 'Baptism Requests (Priest Panel)')

@section('content_header')
    <h1>Baptism Requests (Priest Panel)</h1>
@stop

@section('content')
<div class="py-6">
        <div class="max-w-6xl mx-auto bg-white shadow p-6 rounded">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Submitted By</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse($records as $record)
                    <tr>
                        <td>{{ $record->member?->full_name ?? $record->full_name }}</td>
                        <td>{{ $record->submitter?->name }}</td>
                        <td>
                            <span class="badge bg-warning">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('priest.baptisms.show', $record) }}">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No baptism records yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop