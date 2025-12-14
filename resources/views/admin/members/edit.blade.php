@extends('adminlte::page')

@section('title', 'Edit Member')

@section('content_header')
    <h1>Edit Member — {{ $member->full_name }}</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.members.update', $member) }}">
            @csrf
            @method('PUT')

            @include('admin.members._form')

        </form>
    </div>
</div>
@stop

@section('js')
<script>
    // Auto-hide/show certificate field
    document.getElementById('is_baptised').addEventListener('change', function () {
        let section = document.getElementById('certificate_section');
        section.style.display = this.value == 1 ? 'block' : 'none';
    });

    // Filter SCCs by parish
    document.getElementById('parish_id')?.addEventListener('change', function () {
        fetch('/communities/by-parish/' + this.value)
            .then(response => response.json())
            .then(data => {
                let scc = document.getElementById('small_community_id');
                scc.innerHTML = '<option value="">-- Select SCC --</option>';

                data.forEach(function (item) {
                    scc.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
            });
    });
</script>
@stop