@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-lg text-gray-900']) }}>
    {{ $value ?? $slot }}
</label>
