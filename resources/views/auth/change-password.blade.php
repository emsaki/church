@extends('adminlte::auth.login')

@section('title', 'Change Password')

@section('auth_body')
    <p class="login-box-msg">
        You must change your password before continuing
    </p>

    <form method="POST" action="{{ route('password.force.update') }}">
        @csrf

        {{-- New Password --}}
        <div class="input-group mb-3">
            <input type="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="New Password"
                   required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="input-group mb-3">
            <input type="password"
                   name="password_confirmation"
                   class="form-control"
                   placeholder="Confirm Password"
                   required>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">
                    Change Password
                </button>
            </div>
        </div>
    </form>
@endsection