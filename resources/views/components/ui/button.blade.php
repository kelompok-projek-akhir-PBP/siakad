@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'disabled' => false,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer gap-2';

    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-1.5 text-xs rounded-md',
        'lg' => 'px-5 py-2.5 text-base rounded-xl',
        default => 'px-4 py-2 text-sm rounded-lg',
    };

    $variantClasses = match ($variant) {
        'secondary' => 'bg-secondary text-white hover:bg-[#214887] focus:ring-secondary/50 shadow-sm active:bg-[#1a3869]',
        'light' => 'bg-primary-subtle text-secondary hover:bg-primary-light/40 focus:ring-primary/40 font-semibold',
        'outline' => 'border border-primary text-primary hover:bg-primary hover:text-white focus:ring-primary/40',
        'outline-secondary' => 'border border-secondary text-secondary hover:bg-secondary hover:text-white focus:ring-secondary/40',
        'ghost' => 'text-primary hover:bg-primary-subtle/50 focus:ring-primary/30',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500/50 shadow-sm',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500/50 shadow-sm',
        default => 'bg-primary text-white hover:bg-[#117ec2] focus:ring-primary/50 shadow-sm active:bg-[#0e6ba6]',
    };

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </button>
@endif
