@extends('adminlte::page')

@section('title', 'Tithe – SCC Summary')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-users"></i> SCC Tithe Summary – {{ $community->name }}
    </h1>
@stop

@section('content')

<div class="card shadow-lg">

    <div class="card-header bg-secondary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-users"></i> Members & Tithes
        </h3>
    </div>

    <div class="card-body">

        <div class="alert alert-info">
            <strong>Total Collected:</strong>
            {{ number_format($total, 0, '.', ',') }} Tsh
        </div>

        <table class="table table-bordered table-striped">
            <thead class="bg-light">
                <tr>
                    <th>Member</th>
                    <th>Last Contribution</th>
                    <th>Total Given</th>
                    <th style="width:100px;">Details</th>
                </tr>
            </thead>

            <tbody>
                @foreach($members as $m)
                    @php
                        $memberTithes = $m->tithes ?? collect();
                    @endphp

                    <tr>
                        <td>{{ $m->full_name }}</td>

                        <td>
                            {{ optional($memberTithes->sortByDesc('tithe_date')->first())->tithe_date ?? '-' }}
                        </td>

                        <td>
                            {{ number_format($memberTithes->sum('amount'), 0, '.', ',') }} Tsh
                        </td>

                        <td class="text-center">
                            <a href="{{ route('priest.tithes.member', $m->id) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>

    </div>
</div>

@stop