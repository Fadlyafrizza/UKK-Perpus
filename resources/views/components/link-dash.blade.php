@props(['active'])

@php
    $classes =
        $active ?? false
            ? ' p-2 underline rounded-md text-gray-900 transition duration-150 ease-in-out'
            : ' p-2 hover:underline text-gray-700 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300';
@endphp

<li>
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
