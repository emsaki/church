{{-- resources/views/admin/members/_form.blade.php --}}

@php
    $isEdit = isset($member);
@endphp

{{-- ========================= --}}
{{-- PERSONAL INFORMATION --}}
{{-- ========================= --}}
<h4 class="text-secondary font-weight-bold mb-3">
    <i class="fas fa-id-card"></i> Personal Information
</h4>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">First Name <span class="text-danger">*</span></label>
        <input type="text" name="first_name" class="form-control"
               value="{{ old('first_name', $member->first_name ?? '') }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Middle Name</label>
        <input type="text" name="middle_name" class="form-control"
               value="{{ old('middle_name', $member->middle_name ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Last Name <span class="text-danger">*</span></label>
        <input type="text" name="last_name" class="form-control"
               value="{{ old('last_name', $member->last_name ?? '') }}" required>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Gender</label>
        <select name="gender" class="form-control">
            <option value="">-- Select --</option>
            <option value="M" {{ old('gender', $member->gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
            <option value="F" {{ old('gender', $member->gender ?? '') == 'F' ? 'selected' : '' }}>Female</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Date of Birth</label>
        <input type="date" name="dob" class="form-control"
               value="{{ old('dob', $member->dob ?? '') }}">
    </div>
</div>

{{-- ========================= --}}
{{-- PARISH & SCC --}}
{{-- ========================= --}}
<h4 class="text-secondary font-weight-bold mt-4 mb-3">
    <i class="fas fa-church"></i> Parish & Community
</h4>

@if(auth()->user()->hasRole('admin'))

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Parish</label>
        <select name="parish_id" id="parish_id" class="form-control" required>
            <option value="">-- Select Parish --</option>
            @foreach($parishes as $parish)
                <option value="{{ $parish->id }}"
                    {{ old('parish_id', $member->parish_id ?? '') == $parish->id ? 'selected' : '' }}>
                    {{ $parish->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="font-weight-bold">Small Community (SCC)</label>
        <select name="small_community_id" id="small_community_id" class="form-control" required>
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

{{-- SCC LEADER – READ-ONLY --}}
<input type="hidden" name="parish_id" value="{{ $parishes->first()->id }}">
<input type="hidden" name="small_community_id" value="{{ $communities->first()->id }}">

<div class="alert alert-info">
    <i class="fas fa-users"></i>
    <strong>Assigned SCC:</strong> {{ $communities->first()->name }}
</div>

@endif

{{-- ========================= --}}
{{-- CONTACT INFORMATION --}}
{{-- ========================= --}}
<h4 class="text-secondary font-weight-bold mt-4 mb-3">
    <i class="fas fa-phone"></i> Contact Information
</h4>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Phone</label>
        <input type="text" name="phone" class="form-control"
               value="{{ old('phone', $member->phone ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email', $member->email ?? '') }}">
    </div>
</div>

{{-- ========================= --}}
{{-- BAPTISM INFORMATION --}}
{{-- ========================= --}}
<h4 class="text-secondary font-weight-bold mt-4 mb-3">
    <i class="fas fa-baby"></i> Baptism Information
</h4>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Baptised?</label>
        <select name="is_baptised" id="is_baptised" class="form-control">
            <option value="0">No</option>
            <option value="1"
                {{ old('is_baptised', $member->is_baptised ?? '') == 1 ? 'selected' : '' }}>
                Yes
            </option>
        </select>
    </div>

    <div class="col-md-8 mb-3" id="certificate_section"
         style="{{ old('is_baptised', $member->is_baptised ?? '') == 1 ? '' : 'display:none;' }}">
        <label class="font-weight-bold">Baptism Certificate No.</label>
        <input type="text" name="baptism_certificate_no" class="form-control"
               value="{{ old('baptism_certificate_no', $member->baptism_certificate_no ?? '') }}">
    </div>
</div>

{{-- SUBMIT BUTTON --}}
<div class="text-right mt-4">
    <button class="btn btn-primary px-4 py-2">
        <i class="fas fa-save"></i>
        {{ $isEdit ? 'Update Member' : 'Save Member' }}
    </button>
</div>