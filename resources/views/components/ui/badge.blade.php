@props([
    'variant' => 'primary',
    'size' => 'md',
    'dot' => false,
])

@php
    $baseClasses = 'inline-flex items-center font-medium rounded-full';

    $sizeClasses = match ($size) {
        'sm' => 'text-[11px] px-2 py-0.5 gap-1',
        default => 'text-xs px-2.5 py-1 gap-1.5',
    };

    $variantClasses = match ($variant) {
        'secondary' => 'bg-secondary/10 text-secondary border border-secondary/20',
        'light' => 'bg-primary-subtle text-secondary border border-primary-light/40 font-semibold',
        'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'warning' => 'bg-amber-50 text-amber-700 border border-amber-200',
        'danger' => 'bg-red-50 text-red-700 border border-red-200',
        'neutral' => 'bg-gray-100 text-gray-700 border border-gray-200',
        default => 'bg-primary-subtle text-primary border border-primary-light/60',
    };

    $dotColor = match ($variant) {
        'secondary' => 'bg-secondary',
        'light' => 'bg-secondary',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-red-500',
        'neutral' => 'bg-gray-400',
        default => 'bg-primary',
    };
@endphp

<span {{ $attributes->merge(['class' => "{$baseClasses} {$sizeClasses} {$variantClasses}"]) }}>
    @if ($dot)
        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ $dotColor }}"></span>
    @endif
    {{ $slot }}
</span>
