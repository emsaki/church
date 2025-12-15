@extends('adminlte::page')

@section('title', 'Assign SCC Leader')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-users-cog text-primary"></i> Members of {{ $parish->name }}
    </h1>
@stop

@section('content')

{{-- BACK LINK --}}
<div class="mb-3">
    <a href="{{ route('admin.parishes.index') }}" class="btn btn-sm btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Parishes
    </a>
</div>


<div class="card shadow-lg">

    {{-- HEADER --}}
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-church"></i> Parish: {{ $parish->name }}
        </h3>
    </div>

    {{-- BODY --}}
    <div class="card-body p-0">

        <table class="table table-striped table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th style="width: 30%">Name</th>
                    <th style="width: 25%">Small Christian Community (SCC)</th>
                    <th style="width: 20%">Phone</th>
                    <th style="width: 15%" class="text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($members as $m)
                    <tr>
                        <td>
                            <strong>{{ $m->first_name }} {{ $m->last_name }}</strong>
                        </td>

                        <td>
                            {{ $m->community->name ?? '-' }}
                        </td>

                        <td>
                            {{ $m->phone ?? '-' }}
                        </td>

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
                            <i class="fas fa-info-circle"></i> No members found for this parish.
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
