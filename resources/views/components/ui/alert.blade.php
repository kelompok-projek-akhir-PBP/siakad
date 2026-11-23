@props([
    'type' => 'info',
    'title' => null,
    'dismissible' => false,
])

@php
    $typeClasses = match ($type) {
        'success' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
        'warning' => 'bg-amber-50 border-amber-200 text-amber-800',
        'danger' => 'bg-red-50 border-red-200 text-red-800',
        default => 'bg-primary-subtle/50 border-primary-light/60 text-secondary',
    };

    $iconColor = match ($type) {
        'success' => 'text-emerald-500',
        'warning' => 'text-amber-500',
        'danger' => 'text-red-500',
        default => 'text-primary',
    };
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    {{ $attributes->merge(['class' => "p-4 rounded-xl border flex items-start gap-3 text-sm leading-relaxed transition-all {$typeClasses}"]) }}
    role="alert"
>
    <div class="shrink-0 mt-0.5 {{ $iconColor }}">
        @if ($type === 'success')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @elseif ($type === 'warning')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        @elseif ($type === 'danger')
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @else
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @endif
    </div>

    <div class="flex-1">
        @if ($title)
            <h4 class="font-semibold mb-0.5 text-inherit">{{ $title }}</h4>
        @endif
        <div class="opacity-90">{{ $slot }}</div>
    </div>

    @if ($dismissible)
        <button
            type="button"
            onclick="this.closest('[role=alert]').remove()"
            class="shrink-0 -mr-1 -mt-1 p-1 text-gray-400 hover:text-gray-600 rounded-md hover:bg-black/5 cursor-pointer"
            aria-label="Close"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>
