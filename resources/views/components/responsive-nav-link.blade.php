@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-2 py-1 shadow-sm rounded-lg border-l-4 border-gray-100 text-left text-base font-medium text-white bg-gray-0 focus:outline-none focus:text-indigo-800 focus:bg-gray-50 focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'block w-full px-2 py-1 shadow-sm rounded-lg border-l-4 border-gray-900 text-left text-base font-medium text-gray-900 bg-gray-50 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
