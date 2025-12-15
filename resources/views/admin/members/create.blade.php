@extends('adminlte::page')

@section('title', 'Add Member')

@section('content_header')
    <h1 class="font-weight-bold">
        <i class="fas fa-user-plus text-primary"></i> Add Member
    </h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">

        {{-- MAIN CARD --}}
        <div class="card shadow-lg">

            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user"></i> Member Registration
                </h3>
            </div>

            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the errors below:</strong>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.members.store') }}">
                    @csrf

                    @include('admin.members._form')

                </form>

            </div>
        </div>

    </div>
</div>

@stop

@section('js')
<script>
    // Auto-hide/show certificate field
    document.getElementById('is_baptised')?.addEventListener('change', function () {
        let section = document.getElementById('certificate_section');
        section.style.display = this.value == 1 ? 'block' : 'none';
    });

    // Load SCC dynamically
    document.getElementById('parish_id')?.addEventListener('change', function () {
        fetch('/communities/by-parish/' + this.value)
            .then(response => response.json())
            .then(data => {
                let scc = document.getElementById('small_community_id');
                scc.innerHTML = '<option value="">-- Select SCC --</option>';
                data.forEach(item => {
                    scc.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
            });
    });
</script>
@stop
