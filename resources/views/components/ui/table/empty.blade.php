@props([
    'colspan' => 1,
    'title' => 'Belum ada data',
    'description' => null,
    'icon' => null,
])

<tr>
    <td colspan="{{ $colspan }}" {{ $attributes->merge(['class' => 'px-6 py-12 text-center']) }}>
        <div class="flex flex-col items-center justify-center text-center">
            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500">
                @if ($icon)
                    {!! $icon !!}
                @else
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                @endif
            </div>
            <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $title }}</h4>
            @if ($description)
                <p class="mt-1 max-w-sm text-xs text-gray-500 dark:text-gray-400">{{ $description }}</p>
            @endif
            @if (!$slot->isEmpty())
                <div class="mt-4">
                    {{ $slot }}
                </div>
            @endif
        </div>
    </td>
</tr>
