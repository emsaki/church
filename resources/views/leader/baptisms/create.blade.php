@extends('adminlte::page')

@section('title', 'Baptism Request')

@section('content_header')
    <h1>Submit Baptism Request</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ route('leader.baptisms.store') }}">
            @csrf

            <!-- Select Member or Newborn -->
            <div class="mb-4">
                <label class="font-weight-bold mb-2">Is this baptism request for an existing SCC Member?</label>

                <select name="is_member" id="is_member" class="form-control" required>
                    <option value="">-- Select Option --</option>
                    <option value="1">Yes - Existing Member</option>
                    <option value="0">No - Newborn / Non-member</option>
                </select>
            </div>

            <!-- Existing Member Section -->
            <div id="member_section" class="d-none">

                <div class="mb-3">
                    <label class="font-weight-bold">Select Member</label>
                    <select name="member_id" class="form-control">
                        <option value="">-- Select Member --</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->full_name }} ({{ $m->gender }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Notes (Optional)</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>

            </div>

            <!-- Newborn Section -->
            <div id="newborn_section" class="d-none">

                <div class="mb-3">
                    <label class="font-weight-bold">Full Name</label>
                    <input type="text" name="full_name" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Date of Birth</label>
                    <input type="date" name="dob" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Father's Name</label>
                    <input type="text" name="father_name" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Mother's Name</label>
                    <input type="text" name="mother_name" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="font-weight-bold">Notes (Optional)</label>
                    <textarea name="notes" class="form-control"></textarea>
                </div>

            </div>

            <button class="btn btn-primary mt-3">Submit Request</button>
        </form>

    </div>
</div>
@stop

@section('js')
<script>
    document.getElementById('is_member').addEventListener('change', function() {
        let value = this.value;

        const memberSection = document.getElementById('member_section');
        const newbornSection = document.getElementById('newborn_section');

        if (value === "1") {
            memberSection.classList.remove('d-none');
            newbornSection.classList.add('d-none');
        } else if (value === "0") {
            newbornSection.classList.remove('d-none');
            memberSection.classList.add('d-none');
        } else {
            memberSection.classList.add('d-none');
            newbornSection.classList.add('d-none');
        }
    });
</script>
@stop
