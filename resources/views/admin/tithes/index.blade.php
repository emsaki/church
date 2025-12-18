@extends('adminlte::page')

@section('title', 'Tithe Collections by SCC')

@section('content_header')
    <h1 class="font-weight-bold">Small Community Tithes Summary</h1>
@stop

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <!-- FILTERS -->
        <form class="row mb-3">
            <div class="col-md-3">
                <label>Parish</label>
                <select name="parish_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- All Parishes --</option>
                    @foreach($parishes as $parish)
                        <option value="{{ $parish->id }}" {{ request('parish_id') == $parish->id ? 'selected' : '' }}>
                            {{ $parish->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label>SCC</label>
                <select name="community_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- All SCCs --</option>
                    @foreach($communities as $c)
                        <option value="{{ $c->id }}" {{ request('community_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>From</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>

            <div class="col-md-2">
                <label>To</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>

            <div class="col-md-2 mt-4">
                <button class="btn btn-primary btn-block">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </form>

        <!-- TOTAL SUM -->
        <div class="alert alert-info">
            <strong>Total Tithes:</strong> {{ number_format($totalAmount, 2) }} Tsh
        </div>

        <!-- SCC LIST TABLE -->
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>SCC Name</th>
                    <th>Parish</th>
                    <th>Members</th>
                    <th>Total Contributions</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sccs as $scc)
                <tr>
                    <td>{{ $scc->name }}</td>
                    <td>{{ $scc->parish->name ?? '-' }}</td>
                    <td>{{ $scc->members_count }}</td>
                    <td><strong>{{ number_format($scc->tithes_sum_amount, 2) }}</strong></td>
                    <td>
                        <a href="{{ route('admin.tithes.scc.members', $scc->id) }}"
                           class="btn btn-sm btn-info">
                            <i class="fas fa-folder-open"></i> Open SCC
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        {{ $sccs->links() }}

    </div>
</div>

@stop