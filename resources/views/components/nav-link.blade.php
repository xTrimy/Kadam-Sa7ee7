@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 pt-1 border-b-4 border-secondary-dark text-sm font-medium leading-5 text-gray-100 focus:outline-none focus:border-primary-light transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 pt-1 border-b-4 border-transparent text-sm font-medium leading-5 text-gray-200 hover:text-gray-100 hover:border-white focus:outline-none focus:text-gray-300 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
