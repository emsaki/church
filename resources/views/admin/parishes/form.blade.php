{{-- PARISH NAME --}}
<div class="form-group mb-4">
    <label class="font-weight-bold text-primary">Parish Name <span class="text-danger">*</span></label>
    <input type="text"
           name="name"
           class="form-control form-control-lg"
           placeholder="Enter parish name"
           value="{{ old('name', $parish->name ?? '') }}"
           required>
</div>

{{-- PRIEST ASSIGNMENT --}}
<div class="form-group mb-4">
    <label class="font-weight-bold text-primary">Assign Priest</label>

    <select name="priest_id" class="form-control form-control-lg">
        <option value="">— No Priest Assigned —</option>

        @foreach($priests as $priest)
            <option value="{{ $priest->id }}"
                @selected(old('priest_id', $parish->priest_id ?? '') == $priest->id)>
                {{ $priest->full_name }}
            </option>
        @endforeach
    </select>
</div>

{{-- EMAIL --}}
<div class="form-group mb-4">
    <label class="font-weight-bold text-primary">Email</label>
    <input type="email"
           name="email"
           class="form-control form-control-lg"
           placeholder="Parish email address"
           value="{{ old('email', $parish->email ?? '') }}">
</div>

{{-- PHONE --}}
<div class="form-group mb-4">
    <label class="font-weight-bold text-primary">Phone</label>
    <input type="text"
           name="phone"
           class="form-control form-control-lg"
           placeholder="Parish phone number"
           value="{{ old('phone', $parish->phone ?? '') }}">
</div>

{{-- LOCATION --}}
<div class="form-group mb-4">
    <label class="font-weight-bold text-primary">Location</label>
    <input type="text"
           name="location"
           class="form-control form-control-lg"
           placeholder="Physical parish location"
           value="{{ old('location', $parish->location ?? '') }}">
</div>
