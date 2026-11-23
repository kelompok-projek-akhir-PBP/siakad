@props([
    'name' => null,
    'id' => null,
    'label' => null,
    'value' => null,
    'rows' => 3,
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hint' => null,
])

@php
    $textareaId = $id ?? $name ?? 'textarea-' . uniqid();
    $hasError = !empty($error) || ($name && $errors->has($name));
    $errorMessage = $error ?? ($name ? $errors->first($name) : null);

    $borderClasses = $hasError
        ? 'border-red-400 focus:border-red-500 focus:ring-red-200'
        : 'border-gray-300 focus:border-primary focus:ring-primary/20';
@endphp

<div class="w-full">
    @if ($label)
        <x-ui.label :for="$textareaId" :value="$label" :required="$required" />
    @endif

    <textarea
        @if ($name) name="{{ $name }}" @endif
        id="{{ $textareaId }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if ($required) required @endif
        @if ($disabled) disabled @endif
        {{ $attributes->merge([
            'class' => "w-full text-sm text-gray-800 bg-white border rounded-lg px-3.5 py-2.5 transition-colors duration-150 focus:outline-none focus:ring-2 disabled:bg-gray-100 disabled:cursor-not-allowed {$borderClasses}"
        ]) }}
    >{{ old($name, $value ?? $slot) }}</textarea>

    @if ($errorMessage)
        <p class="text-xs text-red-600 mt-1 font-medium">{{ $errorMessage }}</p>
    @elseif ($hint)
        <p class="text-xs text-gray-500 mt-1">{{ $hint }}</p>
    @endif
</div>
