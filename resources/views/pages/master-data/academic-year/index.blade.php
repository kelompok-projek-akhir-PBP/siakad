<x-layout.main title="Tahun Ajaran">
    <header class="mb-3">
        <h1>Tahun Ajaran</h1>
        <hr class="text-gray-200 my-5">
    </header>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 md:col-span-4">
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
                            value="{{ old('name') }}"
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
                                value="{{ old('start_date') }}"
                                required
                            />
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <x-ui.input
                                name="end_date"
                                id="end_date"
                                type="date"
                                label="Tanggal Selesai"
                                value="{{ old('end_date') }}"
                                required
                            />
                        </div>
                    </div>
                    <div class="mb-3 text-end">
                        <input id="is_active" name="is_active_checkbox" type="checkbox">
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
        <div class="col-span-12 md:col-span-8">
            <x-ui.card title="Data Tahun Ajaran">
                <form action="{{ route('academic-years.index') }}" method="GET">
                    <x-ui.input
                        id="search"
                        name="search"
                        placeholder="Cari Tahun Ajaran"
                        value="{{ request('search') }}"
                    />
                    <button type="submit" class="d-none"></button>
                </form>
                <x-ui.table :striped="True" :headers="['No', 'Nama', 'Tanggal Mulai', 'Tanggal Selesai', 'Aktif', 'Aksi']">
                    @foreach ($academicYears as $index => $item)
                        <tr>
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-center">{{ $item->start_date }}</td>
                            <td class="text-center">{{ $item->end_date }}</td>
                            <td class="text-center" >{{ $item->is_active }}</td>
                            <td class="px-3">
                                <div class="flex gap-1 items-center justify-center">
                                    <div>
                                        <x-ui.button onclick="window.location.href='{{ route('academic-years.edit', $item->id) }}'" type="button" variant="primary">
                                            <x-lucide-pencil class="w-4 h-4" />
                                        </x-ui.button>
                                    </div>
                                    <form action="{{ route('academic-years.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button type="submit" variant="danger">
                                            <x-lucide-trash class="w-4 h-4" />
                                        </x-ui.button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-ui.table>

                <div class="my-3">
                    {{ $academicYears->links() }}
                </div>
            </x-ui.card>
        </div>
    </div>
</x-layout.main>
