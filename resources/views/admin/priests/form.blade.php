{{-- Priest Form Partial --}}

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label><strong>First Name</strong></label>
            <input type="text" name="first_name" class="form-control"
                   value="{{ old('first_name', $priest->first_name ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label><strong>Middle Name</strong></label>
            <input type="text" name="middle_name" class="form-control"
                   value="{{ old('middle_name', $priest->middle_name ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label><strong>Last Name</strong></label>
            <input type="text" name="last_name" class="form-control"
                   value="{{ old('last_name', $priest->last_name ?? '') }}" required>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label><strong>Phone</strong></label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone', $priest->phone ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label><strong>Email</strong></label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $priest->email ?? '') }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label><strong>Ordination Year</strong></label>
            <input type="number" name="ordination_year" class="form-control"
                   placeholder="e.g. 2015"
                   value="{{ old('ordination_year', $priest->ordination_year ?? '') }}">
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <label><strong>Active?</strong></label>
            <select name="active" class="form-control">
                <option value="1" {{ old('active', $priest->active ?? 1) == 1 ? 'selected' : '' }}>
                    Yes
                </option>
                <option value="0" {{ old('active', $priest->active ?? '') == 0 ? 'selected' : '' }}>
                    No
                </option>
            </select>
        </div>
    </div>

</div>
