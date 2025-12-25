@extends('adminlte::page')

@section('title', 'Assign Priest')

@section('content_header')
<h1 class="font-weight-bold text-primary">
    <i class="fas fa-user-plus"></i> Assign Priest to {{ $parish->name }}
</h1>
@stop

@section('content')

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="row">

    {{-- LEFT SIDE: ACTIVE PRIESTS --}}
    <div class="col-md-6">
        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user-friends"></i> Active Priests
                </h4>
            </div>

            <div class="card-body">

                @if($activePriests->count())
                    <ul class="list-group">
                        @foreach($activePriests as $ap)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $ap->full_name }}</strong>  
                                    <br>
                                    <small class="text-muted">Assigned: {{ $ap->pivot->assigned_from }}</small>
                                </div>

                                <form action="{{ route('admin.parishes.unassign', [
                                        'parish' => $parish->id,
                                        'priest' => $ap->pivot->priest_id
                                    ]) }}" 
                                    method="POST"
                                      onsubmit="return confirm('Remove this priest from the parish?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center">
                        <em>No active priests assigned.</em>
                    </p>
                @endif

            </div>

        </div>
    </div>


    {{-- RIGHT SIDE: ASSIGN NEW PRIEST --}}
    <div class="col-md-6">
        <div class="card shadow">

            <div class="card-header bg-success text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user-plus"></i> Assign a New Priest
                </h4>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.parishes.assign.store', $parish->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="font-weight-bold">Select Priest</label>
                        <select name="priest_id" class="form-control select2" required>
                            <option value="">— Choose Priest —</option>
                            @foreach($priests as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->full_name }} ({{ $p->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Assign Priest
                    </button>
                </form>

            </div>

        </div>
    </div>

</div>


{{-- HISTORY SECTION --}}
<div class="card shadow mt-4">

    <div class="card-header bg-secondary text-white">
        <h4 class="mb-0">
            <i class="fas fa-history"></i> Priest Assignment History
        </h4>
    </div>

    <div class="card-body p-0">

        <table class="table table-striped mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Priest</th>
                    <th>Assigned From</th>
                    <th>Assigned To</th>
                </tr>
            </thead>

            <tbody>
                @forelse($history as $h)
                    <tr>
                        <td>{{ $h->priest?->full_name }}</td>
                        <td>{{ $h->assigned_from }}</td>
                        <td>{{ $h->assigned_to ?? 'Active' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-3">
                            <em>No assignment history found.</em>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@stop


@section('js')
<script>
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Select a priest'
    });
</script>
@endsection
