@props([
    'type' => 'text',
    'name' => null,
    'id' => null,
    'label' => null,
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
    'icon' => null,
])

@php
    $inputId = $id ?? $name ?? 'input-' . uniqid();
    $hasError = !empty($error) || ($name && $errors->has($name));
    $errorMessage = $error ?? ($name ? $errors->first($name) : null);

    $borderClasses = $hasError
        ? 'border-red-400 focus:border-red-500 focus:ring-red-200'
        : 'border-gray-300 focus:border-primary focus:ring-primary/20';
@endphp

<div class="w-full">
    @if ($label)
        <x-ui.label :for="$inputId" :value="$label" :required="$required" />
    @endif

    <div class="relative rounded-lg">
        @if ($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                {!! $icon !!}
            </div>
        @endif

        <input
            type="{{ $type }}"
            @if ($name) name="{{ $name }}" @endif
            id="{{ $inputId }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            @if ($disabled) disabled @endif
            {{ $attributes->merge([
                'class' => "w-full text-sm text-gray-800 bg-white border rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 disabled:bg-gray-100 disabled:cursor-not-allowed " .
                    ($icon ? 'pl-10 pr-3.5 py-2.5 ' : 'px-3.5 py-2.5 ') .
                    $borderClasses
            ]) }}
        />
    </div>

    @if ($errorMessage)
        <p class="text-xs text-red-600 mt-1 flex items-center gap-1 font-medium">
            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span>{{ $errorMessage }}</span>
        </p>
    @elseif ($hint)
        <p class="text-xs text-gray-500 mt-1">{{ $hint }}</p>
    @endif
</div>
