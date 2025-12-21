@extends('adminlte::page')

@section('title', 'Baptism Records')

@section('content')

<div class="card shadow-lg mt-4">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0"><i class="fas fa-book"></i> Baptism Records</h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Baptism Date</th>
                    <th>Certificate No</th>
                    <th>Parish</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($records as $r)
                <tr>
                    <td>{{ $r->member?->full_name ?? $r?->full_name }}</td>
                    <td>{{ $r->baptism_date ?? '—' }}</td>
                    <td>{{ $r->certificate_number ?? '—' }}</td>
                    <td>{{ $r->parish->name ?? '—' }}</td>
                    <td>
                        <a href="{{ route('priest.baptisms.records.edit', $r->id) }}"
                           class="btn btn-sm btn-primary">
                           <i class="fas fa-edit"></i> Update
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
