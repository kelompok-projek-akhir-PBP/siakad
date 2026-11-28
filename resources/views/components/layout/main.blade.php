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

    <script>
            document.addEventListener('submit', function (e) {
            const form = e.target.closest('.delete-form');
                if (!form) return;

                e.preventDefault();

                Swal.fire({
                    title: form.dataset.title || 'Apakah Anda yakin?',
                    text: form.dataset.text || 'Data yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>
</x-layout.app>
