@extends('adminlte::page')

@section('title', 'Submit Baptism Request')

@section('content_header')
    <h1 class="font-weight-bold text-primary">
        <i class="fas fa-baby"></i> Submit Baptism Request
    </h1>
@stop

@section('content')

<div class="card shadow-lg">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- CARD HEADER --}}
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">
            <i class="fas fa-file-alt"></i> Baptism Request Form
        </h3>
    </div>

    {{-- CARD BODY --}}
    <div class="card-body">

        <form method="POST" action="{{ route('leader.baptisms.store') }}">
            @csrf

            {{-- SELECT TYPE --}}
            <div class="form-group mb-4">
                <label class="font-weight-bold">
                    <i class="fas fa-users"></i> Is this baptism for an existing SCC member?
                </label>

                <select name="is_member" id="is_member" class="form-control" required>
                    <option value="">— Select Option —</option>
                    <option value="1">Yes — Existing Member</option>
                    <option value="0">No — Newborn / Non-member</option>
                </select>
            </div>

            <hr>

            {{-- EXISTING MEMBER SECTION --}}
            <div id="member_section" class="d-none">

                <h5 class="font-weight-bold text-secondary mb-3">
                    <i class="fas fa-user-check text-primary"></i> Select Member
                </h5>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Member</label>
                    <select name="member_id" class="form-control">
                        <option value="">— Select Member —</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->full_name }} ({{ $m->gender }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Notes (Optional)</label>
                    <textarea name="notes" rows="3" class="form-control"></textarea>
                </div>

            </div>

            {{-- NEWBORN / NON-MEMBER SECTION --}}
            <div id="newborn_section" class="d-none">

                <h5 class="font-weight-bold text-secondary mb-3">
                    <i class="fas fa-baby-carriage text-info"></i> Newborn / Non-member Information
                </h5>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Full Name</label>
                        <input type="text" name="full_name" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Father's Name</label>
                        <input type="text" name="father_name" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Mother's Name</label>
                        <input type="text" name="mother_name" class="form-control">
                    </div>

                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">Notes (Optional)</label>
                    <textarea name="notes" rows="3" class="form-control"></textarea>
                </div>

            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="text-right mt-4">
                <button class="btn btn-success px-4 py-2">
                    <i class="fas fa-paper-plane"></i> Submit Request
                </button>
            </div>

        </form>

    </div>

</div>

@stop


@section('js')
    <script>
        document.getElementById('is_member').addEventListener('change', function() {
            let val = this.value;

            const memberSection = document.getElementById('member_section');
            const newbornSection = document.getElementById('newborn_section');
            const dobField = document.querySelector('input[name="dob"]');

            if (val === "1") {
                memberSection.classList.remove('d-none');
                newbornSection.classList.add('d-none');

                if (dobField) dobField.removeAttribute('required');
            } 
            else if (val === "0") {
                newbornSection.classList.remove('d-none');
                memberSection.classList.add('d-none');

                if (dobField) dobField.setAttribute('required', 'required');
            } 
            else {
                memberSection.classList.add('d-none');
                newbornSection.classList.add('d-none');
                if (dobField) dobField.removeAttribute('required');
            }
        });
    </script>
@stop
