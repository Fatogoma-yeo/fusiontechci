@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-lg text-gray-200']) }}>
    {{ $value ?? $slot }}
</label>
