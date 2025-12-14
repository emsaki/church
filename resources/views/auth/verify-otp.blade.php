<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Enter the verification code sent to your screen.
    </div>

    @if (session('otp'))
        <div class="mb-4 p-3 bg-blue-100 text-blue-700 rounded">
            <strong>Your OTP is: {{ session('otp') }}</strong>
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf

        <div>
            <x-input-label for="code" value="Verification Code" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Verify
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
