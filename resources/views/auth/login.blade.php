{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMIS Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f2f4f8;
            font-family: "Segoe UI", sans-serif;
        }

        .wrapper {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 900px;
            height: 520px;
            background: #ffffff;
            display: flex;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 6px 25px rgba(0,0,0,0.15);
        }

        /* LEFT IMAGE AREA */
        .left-side {
            width: 62%;
            background: url("/images/pmis.png") center/cover no-repeat;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* RIGHT SIDE LOGIN */
        .right-side {
            width: 38%;
            padding: 45px 55px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .system-title {
            font-size: 14px;
            letter-spacing: 1px;
            color: #0a713c;
            margin-bottom: 15px;
        }

        .logo-img {
            width: 80px;
            margin-bottom: 25px;
        }

        /* PERFECTLY ALIGNED INPUTS */
        form {
            width: 100%;
            max-width: 330px;
            margin: 0 auto;
        }

        .input-box {
            width: 100%;
            margin-bottom: 18px;
            position: relative;
        }

        .input-box input {
            width: 100%;
            padding: 12px 13px;
            border-radius: 4px;
            border: 1px solid #ccc;
            transition: all 0.25s ease-in-out;
            font-size: 14px;
        }

        .input-box input:hover,
        .input-box input:focus {
            border-color: #2744a8;
            box-shadow: 0 0 8px rgba(39, 68, 168, 0.3);
        }

        /* EYE ICON */
        .eye-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }

        /* FIXED BUTTON ALIGNMENT */
        .login-btn {
            width: 100%;
            padding: 12px;
            background: #2744a8;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            font-size: 14px;
        }

        .login-btn:hover {
            background: #1f3692;
            box-shadow: 0 4px 12px rgba(39, 68, 168, 0.35);
            transform: translateY(-2px);
        }
        .login-form-group {
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
        }
        .login-form-group input {
            height: 45px;
            font-size: 15px;
            padding-left: 12px;
        }
        .login-form-group .login-btn {
            width: 100%;
            height: 45px;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .footer-text {
            font-size: 11px;
            color: #555;
            margin-top: 25px;
        }

        /* PMIS GLOW (kept unchanged) */
        .pmis-logo {
            font-size: 78px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 3px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-shadow:
                0 0 10px rgba(255,255,255,0.6),
                0 0 20px rgba(0,255,180,0.8),
                0 0 40px rgba(0,255,180,0.5),
                0 0 70px rgba(0,255,180,0.4);
            animation: glow 3.5s ease-in-out infinite alternate;
        }

        @keyframes glow {
            0% {
                opacity: 0.88;
                transform: scale(1);
            }
            100% {
                opacity: 1;
                transform: scale(1.06);
            }
        }
    </style>
</head>

<body>

<div class="wrapper">

    <div class="login-card">

        <!-- LEFT SIDE IMAGE -->
        <div class="left-side"></div>

        <!-- RIGHT SIDE PANEL -->
        <div class="right-side">

            <div class="system-title">PARISH MANAGEMENT INFORMATION SYSTEM</div>

            <img src="{{ asset('images/church_logo.png') }}" class="logo-img" alt="Church Logo">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-box">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="fa fa-eye eye-btn" onclick="togglePassword()"></i>
                </div>

                <button type="submit" class="login-btn">Login</button>

            </form>

            <div class="footer-text">
                Copyright © {{ date('Y') }} | Parish Management Information System | All Rights Reserved
            </div>

        </div>

    </div>

</div>

<script>
function togglePassword() {
    let pwd = document.getElementById("password");
    pwd.type = (pwd.type === "password") ? "text" : "password";
}
</script>

</body>
</html>
