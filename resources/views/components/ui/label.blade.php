@props([
    'for' => null,
    'value' => null,
    'required' => false,
])

<label @if($for) for="{{ $for }}" @endif {{ $attributes->merge(['class' => 'block text-xs font-semibold uppercase tracking-wider text-gray-700 mb-1.5']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500 font-bold ml-0.5">*</span>
    @endif
</label>
