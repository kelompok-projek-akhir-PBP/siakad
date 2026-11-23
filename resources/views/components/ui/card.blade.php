@props([
    'title' => null,
    'subtitle' => null,
    'header' => null,
    'footer' => null,
    'hover' => false,
])

@php
    $hoverClass = $hover ? 'transition-all duration-200 hover:shadow-md hover:-translate-y-0.5' : '';
@endphp

<div {{ $attributes->merge(['class' => "bg-white rounded-xl border border-gray-200/80 shadow-xs overflow-hidden {$hoverClass}"]) }}>
    @if ($header || $title)
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            @if ($header)
                {{ $header }}
            @else
                <div>
                    <h3 class="text-base font-semibold text-gray-800 leading-tight">
                        {{ $title }}
                    </h3>
                    @if ($subtitle)
                        <p class="text-xs text-gray-500 mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <div class="p-5">
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="px-5 py-3.5 bg-gray-50/75 border-t border-gray-100 text-sm">
            {{ $footer }}
        </div>
    @endif
</div>
