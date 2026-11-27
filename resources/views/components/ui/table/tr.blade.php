@props([
    'hover' => true,
    'active' => false,
])

@php
    $activeClass = $active ? 'bg-primary-subtle/30 dark:bg-gray-800/80 font-medium' : '';
    $hoverClass = $hover ? 'hover:bg-primary-subtle/20 dark:hover:bg-gray-800/60 transition-colors duration-150' : '';
@endphp

<tr {{ $attributes->merge(['class' => "{$hoverClass} {$activeClass}"]) }}>
    {{ $slot }}
</tr>
