@extends('adminlte::page')

@section('title', 'Edit Community')

@section('content_header')
    <h1 class="font-weight-bold">Edit Community (Jumuiya)</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">

        {{-- MAIN CARD --}}
        <div class="card shadow-lg">

            {{-- Header --}}
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-users"></i> Update Community Information
                </h3>
            </div>

            {{-- Body --}}
            <div class="card-body">

                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <strong>There were some issues with your input.</strong>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.communities.update', $community) }}">
                    @csrf
                    @method('PUT')

                    {{-- COMMUNITY NAME --}}
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Community Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $community->name) }}"
                               placeholder="Enter community name"
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
                                    {{ old('parish_id', $community->parish_id) == $parish->id ? 'selected' : '' }}>
                                    {{ $parish->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('parish_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- LEGACY LEADER FIELDS (If still needed) --}}
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Leader Name (Optional)</label>
                        <input type="text"
                               name="leader_name"
                               class="form-control"
                               value="{{ old('leader_name', $community->leader_name) }}"
                               placeholder="Enter leader name (optional)">
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Leader Phone (Optional)</label>
                        <input type="text"
                               name="leader_phone"
                               class="form-control"
                               value="{{ old('leader_phone', $community->leader_phone) }}"
                               placeholder="Enter leader phone (optional)">
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="text-right">
                        <a href="{{ route('admin.communities.index') }}"
                           class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>

                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save"></i> Update Community
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
</div>

@stop