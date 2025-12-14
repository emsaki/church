<div class="form-group">
    <label>First Name</label>
    <input type="text" name="first_name" class="form-control"
           value="{{ old('first_name', $member->first_name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Middle Name</label>
    <input type="text" name="middle_name" class="form-control"
           value="{{ old('middle_name', $member->middle_name ?? '') }}">
</div>

<div class="form-group">
    <label>Last Name</label>
    <input type="text" name="last_name" class="form-control"
           value="{{ old('last_name', $member->last_name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Gender</label>
    <select name="gender" class="form-control">
        <option value="">-- Select --</option>
        <option value="M" {{ old('gender', $member->gender ?? '') == 'M' ? 'selected' : '' }}>Male</option>
        <option value="F" {{ old('gender', $member->gender ?? '') == 'F' ? 'selected' : '' }}>Female</option>
    </select>
</div>

<div class="form-group">
    <label>Date of Birth</label>
    <input type="date" name="dob" class="form-control"
           value="{{ old('dob', $member->dob ?? '') }}">
</div>

{{-- <div class="form-group">
    <label>Parish</label>
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

<div class="form-group">
    <label>Small Community</label>
    <select name="small_community_id" class="form-control">
        <option value="">-- Select SCC --</option>

        @foreach($communities as $c)
            <option value="{{ $c->id }}"
                {{ old('small_community_id', $member->small_community_id ?? '') == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>
</div> --}}

@if(auth()->user()->hasRole('admin'))
    <!-- Show parish dropdown -->
    <div class="form-group">
        <label>Parish</label>
        <select name="parish_id" class="form-control">
            @foreach($parishes as $parish)
                <option value="{{ $parish->id }}">{{ $parish->name }}</option>
            @endforeach
        </select>
    </div>
    <!-- Show SCC dropdown -->
    <div class="form-group">
        <label>Small Community</label>
        <select name="small_community_id" class="form-control">
            @foreach($communities as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
@else
    <!-- Hide from SCC leader -->
    <div class="form-group">
        <input type="hidden" name="parish_id" value="{{ $parishes->first()->id }}">
    </div>
    <div class="form-group">
        <input type="hidden" name="small_community_id" value="{{ $communities->first()->id }}">
    </div>

    <div class="alert alert-info">
        <strong>Assigned to SCC:</strong> {{ $communities->first()->name }}
    </div>
@endif

<div class="form-group">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control"
           value="{{ old('phone', $member->phone ?? '') }}">
</div>

<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control"
           value="{{ old('email', $member->email ?? '') }}">
</div>

<div class="form-group">
    <label>Baptised?</label>
    <select name="is_baptised" class="form-control">
        <option value="0">No</option>
        <option value="1" {{ old('is_baptised', $member->is_baptised ?? '') == 1 ? 'selected' : '' }}>Yes</option>
    </select>
</div>

<div class="form-group">
    <label>Baptism Certificate No.</label>
    <input type="text" name="baptism_certificate_no" class="form-control"
           value="{{ old('baptism_certificate_no', $member->baptism_certificate_no ?? '') }}">
</div>
