<div class="form-group">
    <label>Parish Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $parish->name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Assign Priest</label>
    <select name="priest_id" class="form-control">
        <option value="">-- No Priest Assigned --</option>
        @foreach($priests as $priest)
            <option value="{{ $priest->id }}"
                {{ old('priest_id', $parish->priest_id ?? '') == $priest->id ? 'selected' : '' }}>
                {{ $priest->full_name }}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control"
           value="{{ old('email', $parish->email ?? '') }}">
</div>

<div class="form-group">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control"
           value="{{ old('phone', $parish->phone ?? '') }}">
</div>

<div class="form-group">
    <label>Location</label>
    <input type="text" name="location" class="form-control"
           value="{{ old('location', $parish->location ?? '') }}">
</div>