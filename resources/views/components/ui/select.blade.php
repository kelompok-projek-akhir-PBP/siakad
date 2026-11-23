@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
])

@php
    $selectId = $id ?? $name ?? 'select-' . uniqid();
    $hasError = !empty($error) || ($name && $errors->has($name));
    $errorMessage = $error ?? ($name ? $errors->first($name) : null);

    $borderClasses = $hasError
        ? 'border-red-400 focus:border-red-500 focus:ring-red-200'
        : 'border-gray-300 focus:border-primary focus:ring-primary/20';
@endphp

<div class="w-full">
    @if ($label)
        <x-ui.label :for="$selectId" :value="$label" :required="$required" />
    @endif

    <div class="relative">
        <select
            @if ($name) name="{{ $name }}" @endif
            id="{{ $selectId }}"
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            {{ $attributes->merge([
                'class' => "w-full text-sm text-gray-800 bg-white border rounded-lg px-3.5 py-2.5 appearance-none pr-10 transition-colors duration-150 focus:outline-none focus:ring-2 disabled:bg-gray-100 disabled:cursor-not-allowed {$borderClasses}"
            ]) }}
        >
            @if ($placeholder)
                <option value="" disabled selected>{{ $placeholder }}</option>
            @endif
            {{ $slot }}
        </select>

        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    @if ($errorMessage)
        <p class="text-xs text-red-600 mt-1 font-medium">{{ $errorMessage }}</p>
    @elseif ($hint)
        <p class="text-xs text-gray-500 mt-1">{{ $hint }}</p>
    @endif
</div>
