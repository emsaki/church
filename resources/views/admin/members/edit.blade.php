@extends('adminlte::page')

@section('title', 'Edit Member')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-user-edit text-primary"></i>
        Edit Member — {{ $member->full_name }}
    </h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        {{-- MAIN CARD --}}
        <div class="card shadow-lg">

            <div class="card-header bg-warning text-dark">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user"></i> Update Member Information
                </h3>
            </div>

            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please correct the errors below:</strong>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.members.update', $member) }}">
                    @csrf
                    @method('PUT')

                    @include('admin.members._form')

                </form>

            </div>

        </div>

    </div>
</div>

@stop

@section('js')
<script>
    // Auto toggle certificate field
    const isBaptised = document.getElementById('is_baptised');
    const certificateSection = document.getElementById('certificate_section');

    if (isBaptised && certificateSection) {
        function toggleCert() {
            certificateSection.style.display = isBaptised.value == "1" ? 'block' : 'none';
        }
        isBaptised.addEventListener('change', toggleCert);
        toggleCert();
    }

    // Dynamic SCC loading
    document.getElementById('parish_id')?.addEventListener('change', function () {
        fetch('/communities/by-parish/' + this.value)
            .then(res => res.json())
            .then(data => {
                let scc = document.getElementById('small_community_id');
                scc.innerHTML = '<option value="">-- Select SCC --</option>';

                data.forEach(c => {
                    scc.innerHTML += `<option value="${c.id}">${c.name}</option>`;
                });
            });
    });
</script>
@stop
