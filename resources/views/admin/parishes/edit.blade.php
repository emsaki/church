<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Parish
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6">
        <div class="bg-white p-6 shadow sm:rounded-lg">

            <form method="POST" action="{{ route('admin.parishes.update', $parish) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Parish Name</label>
                    <input type="text" name="name"
                           class="mt-1 block w-full border-gray-300 rounded-md"
                           value="{{ old('name', $parish->name) }}" required>
                    @error('name')
                        <div class="text-red-600 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Location</label>
                    <input type="text" name="location"
                           class="mt-1 block w-full border-gray-300 rounded-md"
                           value="{{ old('location', $parish->location) }}">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.parishes.index') }}"
                       class="px-4 py-2 bg-gray-300 rounded mr-2">Cancel</a>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update Parish
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>
