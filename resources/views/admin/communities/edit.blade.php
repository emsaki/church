<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Community (Jumuiya)
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6">
        <div class="bg-white p-6 shadow sm:rounded-lg">

            <form method="POST" action="{{ route('admin.communities.update', $community) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Community Name</label>
                    <input type="text" name="name"
                           class="mt-1 block w-full border-gray-300 rounded-md"
                           value="{{ old('name', $community->name) }}" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Parish</label>
                    <select name="parish_id" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @foreach($parishes as $parish)
                            <option value="{{ $parish->id }}"
                                {{ $community->parish_id == $parish->id ? 'selected' : '' }}>
                                {{ $parish->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Leader Name</label>
                    <input type="text" name="leader_name"
                           class="mt-1 block w-full border-gray-300 rounded-md"
                           value="{{ old('leader_name', $community->leader_name) }}">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Leader Phone</label>
                    <input type="text" name="leader_phone"
                           class="mt-1 block w-full border-gray-300 rounded-md"
                           value="{{ old('leader_phone', $community->leader_phone) }}">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('admin.communities.index') }}"
                       class="px-4 py-2 bg-gray-300 rounded mr-2">Cancel</a>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update Community
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>
