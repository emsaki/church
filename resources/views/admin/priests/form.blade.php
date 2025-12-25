{{-- =============================
     SHARED PRIEST FORM PARTIAL
   ============================= --}}

<div class="row">

    {{-- First Name --}}
    <div class="col-md-4 mb-4">
        <label class="font-weight-bold">First Name <span class="text-danger">*</span></label>
        <input type="text"
               name="first_name"
               class="form-control form-control-lg"
               placeholder="Enter first name"
               value="{{ old('first_name', $priest->first_name ?? '') }}"
               required>
    </div>

    {{-- Middle Name --}}
    <div class="col-md-4 mb-4">
        <label class="font-weight-bold">Middle Name</label>
        <input type="text"
               name="middle_name"
               class="form-control form-control-lg"
               placeholder="Enter middle name (optional)"
               value="{{ old('middle_name', $priest->middle_name ?? '') }}">
    </div>

    {{-- Last Name --}}
    <div class="col-md-4 mb-4">
        <label class="font-weight-bold">Last Name <span class="text-danger">*</span></label>
        <input type="text"
               name="last_name"
               class="form-control form-control-lg"
               placeholder="Enter last name"
               value="{{ old('last_name', $priest->last_name ?? '') }}"
               required>
    </div>

</div>

<div class="row">

    {{-- Phone --}}
    <div class="col-md-4 mb-4">
        <label class="font-weight-bold">Phone</label>
        <input type="text"
               name="phone"
               class="form-control form-control-lg"
               placeholder="Phone number"
               value="{{ old('phone', $priest->phone ?? '') }}">
    </div>

    {{-- Email --}}
    <div class="col-md-4 mb-4">
        <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
        <input type="email"
               name="email"
               class="form-control form-control-lg"
               placeholder="Email address"
               value="{{ old('email', $priest->email ?? '') }}"
               required>
    </div>

    {{-- Ordination Year --}}
    <div class="col-md-4 mb-4">
        <label class="font-weight-bold">Ordination Year</label>
        <input type="number"
               name="ordination_year"
               class="form-control form-control-lg"
               placeholder="e.g. 2012"
               value="{{ old('ordination_year', $priest->ordination_year ?? '') }}">
    </div>

</div>

<div class="row">

    {{-- Active Status --}}
    <div class="col-md-4 mb-4">
        <label class="font-weight-bold">Active?</label>
        <select name="active" class="form-control form-control-lg">
            <option value="1" {{ old('active', $priest->active ?? 1) == 1 ? 'selected' : '' }}>
                Yes
            </option>
            <option value="0" {{ old('active', $priest->active ?? 1) == 0 ? 'selected' : '' }}>
                No
            </option>
        </select>
    </div>

</div>
{{-- ONLY SHOW WHEN EDITING --}}
    @if(isset($priest) && $priest->exists)
        <div class="col-md-12 mb-4">

            <label class="font-weight-bold">Assigned Parishes</label>

            @php
                $activeParishes = $priest->activeParishes;
            @endphp

            {{-- LIST ACTIVE PRIESTS --}}
            @if($activeParishes->count())
                @foreach($activeParishes as $parish)
                    <span class="badge badge-info mb-1 px-3 py-2">
                        <i class="fas fa-user"></i> {{ $parish->name }}
                    </span><br>
                @endforeach
            @else
                <p class="text-muted mb-1">— No active parish assigned —</p>
            @endif

            {{-- ASSIGN BUTTON --}}
            <div class="mt-3">
                <a href="{{ route('admin.priests.assign.form', $priest->id) }}"
                    class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Assign Parish
                </a>
            </div>
        </div>
    @endif
