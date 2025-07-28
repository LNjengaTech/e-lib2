@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-700 rounded-md transition duration-150 ease-in-out bg-gray-700'
        : 'flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-md transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
