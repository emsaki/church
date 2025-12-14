@props(['label', 'value', 'color' => 'blue'])

<div class="bg-white shadow rounded p-6 border-l-4 border-{{ $color }}-500">
    <p class="text-gray-500 text-sm">{{ $label }}</p>
    <p class="text-3xl font-bold text-{{ $color }}-700">{{ $value }}</p>
</div>
