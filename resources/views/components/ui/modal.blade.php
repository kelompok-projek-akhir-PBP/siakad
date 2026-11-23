@props([
    'id',
    'title' => null,
    'maxWidth' => 'md',
    'footer' => null,
])

@php
    $maxWidthClass = match ($maxWidth) {
        'sm' => 'max-w-sm',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        default => 'max-w-md',
    };
@endphp

<dialog
    id="{{ $id }}"
    class="w-full {{ $maxWidthClass }} p-0 rounded-2xl shadow-xl backdrop:bg-slate-900/40 backdrop:backdrop-blur-xs border border-gray-100 open:animate-in open:fade-in open:zoom-in-95 m-auto"
>
    <div class="bg-white flex flex-col">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-800">
                {{ $title ?? 'Modal' }}
            </h3>
            <button
                type="button"
                onclick="document.getElementById('{{ $id }}').close()"
                class="text-gray-400 hover:text-gray-600 rounded-lg p-1 hover:bg-gray-100 cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 text-sm text-gray-600 leading-relaxed">
            {{ $slot }}
        </div>

        <!-- Footer -->
        @if ($footer)
            <div class="px-6 py-3.5 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-2.5 rounded-b-2xl">
                {{ $footer }}
            </div>
        @endif
    </div>
</dialog>
