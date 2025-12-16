@extends('adminlte::page')

@section('title', 'All Tithes')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-hand-holding-usd"></i> All Tithes
    </h1>
@stop

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-list"></i> Tithe Records
        </h3>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped table-bordered mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Member</th>
                    <th>Parish</th>
                    <th>SCC</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Recorded By</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            @foreach($tithes as $t)
                <tr>
                    <td>{{ $t->member?->full_name }}</td>
                    <td>{{ $t->parish?->name }}</td>
                    <td>{{ $t->community?->name }}</td>
                    <td><strong>{{ number_format($t->amount) }}</strong></td>
                    <td>{{ $t->tithe_date }}</td>
                    <td>{{ $t->recorder?->name }}</td>

                    <td>
                        <a href="{{ route('admin.tithes.edit', $t) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.tithes.destroy', $t) }}"
                              method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this tithe?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

</div>

@stop