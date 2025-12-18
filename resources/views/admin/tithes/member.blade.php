@extends('adminlte::page')

@section('title', 'Tithe History')

@section('content_header')
<h1 class="font-weight-bold">
    Tithe History: {{ $member->full_name }}
</h1>
@stop

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <div class="mb-3">
            <a href="{{ route('admin.tithes.scc.members', $member->small_community_id) }}"
               class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to SCC
            </a>

            <a href="{{ route('admin.tithes.create', ['member' => $member->id]) }}"
               class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle"></i> Add Tithe
            </a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Notes</th>
                    <th>Recorded By</th>
                    <th>Receipt</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tithes as $t)
                <tr>
                    <td>{{ $t->tithe_date }}</td>
                    <td><strong>{{ number_format($t->amount, 2) }}</strong></td>
                    <td>{{ $t->notes }}</td>
                    <td>{{ $t->recorder->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.tithes.receipt', $t->id) }}"
                           class="btn btn-sm btn-info">
                           <i class="fas fa-receipt"></i> Receipt
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</div>

@stop