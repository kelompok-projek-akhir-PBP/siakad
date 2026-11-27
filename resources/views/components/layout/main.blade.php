@props([
    'title' => '',
])

<x-layout.app :title="$title">
    <div class="flex min-h-screen bg-slate-50 dark:bg-gray-950 font-sans transition-colors duration-200">
        <x-sidebar />
        <div class="flex-1 flex flex-col min-w-0">
            <x-navbar />
            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>
            <x-footer />
        </div>
    </div>
</x-layout.app>
