@props([
    'align' => 'left',
    'nowrap' => false,
])

@php
    $alignClass = match ($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };

    $nowrapClass = $nowrap ? 'whitespace-nowrap' : '';
@endphp

<td {{ $attributes->merge(['class' => "px-5 py-3.5 align-middle text-sm text-gray-700 dark:text-gray-300 {$alignClass} {$nowrapClass}"]) }}>
    {{ $slot }}
</td>
