{{-- =============================
     SHARED PARISH FORM PARTIAL
   ============================= --}}

<div class="row">

    {{-- PARISH NAME --}}
    <div class="col-md-12 mb-4">
        <label class="font-weight-bold">Parish Name <span class="text-danger">*</span></label>
        <input type="text" name="name"
               class="form-control form-control-lg"
               placeholder="Enter parish name"
               value="{{ old('name', $parish->name ?? '') }}"
               required>
    </div>

    {{-- EMAIL --}}
    <div class="col-md-12 mb-4">
        <label class="font-weight-bold">Email</label>
        <input type="email" name="email"
               class="form-control form-control-lg"
               placeholder="Parish email address"
               value="{{ old('email', $parish->email ?? '') }}">
    </div>

    {{-- PHONE --}}
    <div class="col-md-12 mb-4">
        <label class="font-weight-bold">Phone</label>
        <input type="text" name="phone"
               class="form-control form-control-lg"
               placeholder="Parish phone number"
               value="{{ old('phone', $parish->phone ?? '') }}">
    </div>

    {{-- LOCATION --}}
    <div class="col-md-12 mb-4">
        <label class="font-weight-bold">Location</label>
        <input type="text" name="location"
               class="form-control form-control-lg"
               placeholder="Physical parish location"
               value="{{ old('location', $parish->location ?? '') }}">
    </div>

    {{-- ONLY SHOW WHEN EDITING --}}
    @if(isset($parish) && $parish->exists)
        <div class="col-md-12 mb-4">

            <label class="font-weight-bold">Assigned Priests</label>

            @php
                $activePriests = $parish->activePriests;
            @endphp

            {{-- LIST ACTIVE PRIESTS --}}
            @if($activePriests->count())
                @foreach($activePriests as $priest)
                    <span class="badge badge-info mb-1 px-3 py-2">
                        <i class="fas fa-user"></i> {{ $priest->full_name }}
                    </span><br>
                @endforeach
            @else
                <p class="text-muted mb-1">— No active priests assigned —</p>
            @endif

            {{-- ASSIGN BUTTON --}}
            <div class="mt-3">
                <a href="{{ route('admin.parishes.assign', $parish->id) }}"
                   class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus"></i> Assign Priest
                </a>
            </div>

        </div>
    @endif

</div>
