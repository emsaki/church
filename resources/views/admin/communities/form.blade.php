{{-- COMMUNITY NAME --}}
<div class="form-group mb-4">
    <label class="font-weight-bold">Community Name <span class="text-danger">*</span></label>
    <input type="text"
           name="name"
           class="form-control @error('name') is-invalid @enderror"
           placeholder="Enter community (Jumuiya) name"
           value="{{ old('name', $community->name ?? '') }}"
           required>

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- PARISH --}}
<div class="form-group mb-4">
    <label class="font-weight-bold">Parish <span class="text-danger">*</span></label>
    <select name="parish_id"
            class="form-control @error('parish_id') is-invalid @enderror"
            required>
        <option value="">-- Select Parish --</option>

        @foreach($parishes as $parish)
            <option value="{{ $parish->id }}"
                {{ old('parish_id', $community->parish_id ?? '') == $parish->id ? 'selected' : '' }}>
                {{ $parish->name }}
            </option>
        @endforeach
    </select>

    @error('parish_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
