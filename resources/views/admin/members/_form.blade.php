{{-- resources/views/admin/members/_form.blade.php --}}

@php
    // When editing, $member is passed. When creating, ensure $member is null-safe.
    $isEdit = isset($member);
@endphp

<div class="row">

    {{-- FIRST NAME --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">First Name <span class="text-danger">*</span></label>
        <input type="text" name="first_name" class="form-control"
               value="{{ old('first_name', $member->first_name ?? '') }}" required>
    </div>

    {{-- MIDDLE NAME --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Middle Name</label>
        <input type="text" name="middle_name" class="form-control"
               value="{{ old('middle_name', $member->middle_name ?? '') }}">
    </div>

    {{-- LAST NAME --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Last Name <span class="text-danger">*</span></label>
        <input type="text" name="last_name" class="form-control"
               value="{{ old('last_name', $member->last_name ?? '') }}" required>
    </div>

</div>


<div class="row">

    {{-- GENDER --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-control">
            <option value="">-- Select --</option>
            <option value="M" {{ old('gender', $member->gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
            <option value="F" {{ old('gender', $member->gender ?? '') == 'F' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    {{-- DOB --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="dob" class="form-control"
               value="{{ old('dob', $member->dob ?? '') }}">
    </div>

</div>



{{-- ADMIN CAN SELECT PARISH + SCC --}}
@if(auth()->user()->hasRole('admin'))

<div class="row">

    {{-- PARISH --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Parish</label>
        <select name="parish_id" class="form-control" required>
            <option value="">-- Select Parish --</option>
            @foreach($parishes as $parish)
                <option value="{{ $parish->id }}"
                    {{ old('parish_id', $member->parish_id ?? '') == $parish->id ? 'selected' : '' }}>
                    {{ $parish->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- SCC --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Small Community (Jumuiya)</label>
        <select name="small_community_id" class="form-control" required>
            <option value="">-- Select SCC --</option>
            @foreach($communities as $c)
                <option value="{{ $c->id }}"
                    {{ old('small_community_id', $member->small_community_id ?? '') == $c->id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

</div>

@else
{{-- SCC LEADER FIXED --}}
<input type="hidden" name="parish_id" value="{{ $parishes->first()->id }}">
<input type="hidden" name="small_community_id" value="{{ $communities->first()->id }}">

<div class="alert alert-info">
    <strong>Assigned SCC:</strong> {{ $communities->first()->name }}
</div>
@endif



<div class="row">

    {{-- PHONE --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $member->phone ?? '') }}">
    </div>

    {{-- EMAIL --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $member->email ?? '') }}">
    </div>

</div>


<div class="row">

    {{-- BAPTISED --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">Baptised?</label>
        <select name="is_baptised" class="form-control">
            <option value="0">No</option>
            <option value="1" {{ old('is_baptised', $member->is_baptised ?? '') == 1 ? 'selected' : '' }}>Yes</option>
        </select>
    </div>

    {{-- CERTIFICATE --}}
    <div class="col-md-8 mb-3">
        <label class="form-label">Baptism Certificate No.</label>
        <input type="text" name="baptism_certificate_no" class="form-control"
               value="{{ old('baptism_certificate_no', $member->baptism_certificate_no ?? '') }}">
    </div>

</div>

<button class="btn btn-primary mt-3">
    {{ $isEdit ? 'Update Member' : 'Save Member' }}
</button>