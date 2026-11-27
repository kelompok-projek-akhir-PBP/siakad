<x-layout.main title="Tahun Ajaran">
    <header class="mb-3">
        <h1>Tahun Ajaran</h1>
        <hr class="text-gray-200 my-5">
    </header>
    <div>
        <x-ui.card title="Buat Tahun Ajaran Baru">
            <form action="{{ route('academic-years.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <x-ui.input
                        name="name"
                        id="name"
                        type="text"
                        label="Nama Tahun Ajaran"
                        placeholder="contoh:2026/2027"
                        value="{{ $accademicYear->name }}"
                        required
                    />
                </div>
                <div class="grid grid-cols-12 gap-4 mb-3">
                    <div class="col-span-12 md:col-span-6">
                        <x-ui.input
                            name="start_date"
                            id="start_ddate"
                            type="date"
                            label="Tanggal Mulai"
                            value="{{ $accademicYear->start_date }}"
                            required
                        />
                    </div>
                    <div class="col-span-12 md:col-span-6">
                        <x-ui.input
                            name="end_date"
                            id="end_date"
                            type="date"
                            label="Tanggal Selesai"
                            value="{{ $accademicYear->end_date }}"
                            required
                        />
                    </div>
                </div>
                <div class="mb-3 text-end">
                    @if ($accademicYear->is_active)
                        <input id="is_active" name="is_active_checkbox" type="checkbox" checked>
                    @else
                        <input id="is_active" name="is_active_checkbox" type="checkbox">
                    @endif
                    <label for="is_active" class="select-none cursor-pointer">Tahun Ajaran Aktif</label>
                </div>
                <div class="my-5 grid grid-cols-12 gap-2">
                    <div class="col-span-12">
                        <x-ui.button type="submit" variant="primary" class="w-full">Kirim</x-ui.button>
                    </div>
                    <div class="col-span-12">
                        <x-ui.button type="reset" variant="outline" class="w-full">Reset</x-ui.button>
                    </div>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layout.main>
