@extends('adminlte::page')

@section('title', 'Assign SCC Leader')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-users text-primary"></i>
        Members of {{ $community->name }}
    </h1>
@stop

@section('content')

{{-- BACK BUTTON --}}
<div class="mb-3">
    <a href="{{ route('admin.communities.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Communities
    </a>
</div>

{{-- MAIN CARD --}}
<div class="card shadow-lg">

    {{-- CARD HEADER --}}
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-church"></i>
            {{ $community->name }} — {{ $community->parish->name }}
        </h3>
    </div>

    {{-- CARD BODY --}}
    <div class="card-body p-0">

        <table class="table table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th style="width: 35%">Name</th>
                    <th style="width: 15%">Gender</th>
                    <th style="width: 20%">Phone</th>
                    <th style="width: 20%" class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $m)
                    <tr>
                        <td>{{ $m->first_name }} {{ $m->middle_name }} {{ $m->last_name }}</td>
                        <td>{{ ucfirst($m->gender) }}</td>
                        <td>{{ $m->phone ?? '-' }}</td>

                        <td class="text-right">
                            <a href="{{ route('admin.members.edit', $m) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle"></i> No members found in this SCC.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- FOOTER WITH PAGINATION --}}
    <div class="card-footer">
        <div class="d-flex justify-content-end">
            {{ $members->links() }}
        </div>
    </div>

</div>

@stop