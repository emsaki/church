<div class="form-group">
    <label>First Name</label>
    <input type="text" name="first_name" class="form-control"
           value="{{ old('first_name', $priest->first_name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Middle Name</label>
    <input type="text" name="middle_name" class="form-control"
           value="{{ old('middle_name', $priest->middle_name ?? '') }}">
</div>

<div class="form-group">
    <label>Last Name</label>
    <input type="text" name="last_name" class="form-control"
           value="{{ old('last_name', $priest->last_name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control"
           value="{{ old('phone', $priest->phone ?? '') }}">
</div>

<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control"
           value="{{ old('email', $priest->email ?? '') }}">
</div>

<div class="form-group">
    <label>Ordination Year</label>
    <input type="text" name="ordination_year" class="form-control"
           value="{{ old('ordination_year', $priest->ordination_year ?? '') }}">
</div>

<div class="form-group">
    <label>Active?</label>
    <select name="active" class="form-control">
        <option value="1" {{ old('active', $priest->active ?? '') == 1 ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ old('active', $priest->active ?? '') == 0 ? 'selected' : '' }}>No</option>
    </select>
</div>