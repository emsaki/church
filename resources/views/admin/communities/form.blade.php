<div class="form-group">
    <label>Community Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $community->name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Parish</label>
    <select name="parish_id" class="form-control" required>
        <option value="">-- Select Parish --</option>

        @foreach($parishes as $parish)
            <option value="{{ $parish->id }}"
                {{ old('parish_id', $community->parish_id ?? '') == $parish->id ? 'selected' : '' }}>
                {{ $parish->name }}
            </option>
        @endforeach
    </select>
</div>