<x-layout.app title="UI Design System Showcase">
    <div class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-6xl mx-auto space-y-10">

            <!-- Header & Palette Section -->
            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 sm:p-8 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">SIAKAD UI Design System & Component Showcase</h1>
                        <p class="text-sm text-gray-500 mt-1">Daftar komponen esensial siap pakai berbasis Tailwind CSS v4 dengan palet warna brand.</p>
                    </div>
                    <div>
                        <x-ui.badge variant="light" size="md" dot>v1.0 Ready</x-ui.badge>
                    </div>
                </div>

                <!-- Palette Preview -->
                <div class="mt-6">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Color Palette Variables</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="p-3.5 rounded-xl border border-gray-100 bg-white shadow-2xs flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-secondary shrink-0 shadow-xs"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-800">Secondary</p>
                                <p class="text-[11px] font-mono text-gray-400">#2C5EAD</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl border border-gray-100 bg-white shadow-2xs flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary shrink-0 shadow-xs"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-800">Primary</p>
                                <p class="text-[11px] font-mono text-gray-400">#1591DC</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl border border-gray-100 bg-white shadow-2xs flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary-light shrink-0 shadow-xs"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-800">Primary Light</p>
                                <p class="text-[11px] font-mono text-gray-400">#4BB8FA</p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl border border-gray-100 bg-white shadow-2xs flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary-subtle border border-primary-light/40 shrink-0 shadow-xs"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-800">Primary Subtle</p>
                                <p class="text-[11px] font-mono text-gray-400">#C4E2F5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1. Buttons Section -->
            <x-ui.card title="1. Button Components (`<x-ui.button>`)" subtitle="Berbagai varian ukuran dan tipe tombol">
                <div class="space-y-6">
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Varian Warna</h4>
                        <div class="flex flex-wrap items-center gap-3">
                            <x-ui.button variant="primary">Primary Button</x-ui.button>
                            <x-ui.button variant="secondary">Secondary Button</x-ui.button>
                            <x-ui.button variant="light">Light / Subtle</x-ui.button>
                            <x-ui.button variant="outline">Outline Primary</x-ui.button>
                            <x-ui.button variant="outline-secondary">Outline Secondary</x-ui.button>
                            <x-ui.button variant="ghost">Ghost Button</x-ui.button>
                            <x-ui.button variant="success">Success</x-ui.button>
                            <x-ui.button variant="danger">Danger</x-ui.button>
                            <x-ui.button variant="primary" disabled>Disabled</x-ui.button>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-5">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Ukuran (Size)</h4>
                        <div class="flex flex-wrap items-center gap-3">
                            <x-ui.button variant="primary" size="sm">Small (sm)</x-ui.button>
                            <x-ui.button variant="primary" size="md">Medium (md)</x-ui.button>
                            <x-ui.button variant="primary" size="lg">Large (lg)</x-ui.button>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-5">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Sebagai Link (`href`) & Dengan Icon</h4>
                        <div class="flex flex-wrap items-center gap-3">
                            <x-ui.button href="#link" variant="secondary">
                                Link Anchor Tag
                            </x-ui.button>
                            <x-ui.button variant="primary">
                                <svg class="w-4 h-4 mr-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Data Baru
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- 2. Badges Section -->
            <x-ui.card title="2. Badge / Tag Components (`<x-ui.badge>`)" subtitle="Label status untuk mahasiswa, nilai, atau registrasi">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Varian & Dot</h4>
                        <div class="flex flex-wrap items-center gap-3">
                            <x-ui.badge variant="primary" dot>Primary (Aktif)</x-ui.badge>
                            <x-ui.badge variant="secondary" dot>Secondary</x-ui.badge>
                            <x-ui.badge variant="light">Light Tag</x-ui.badge>
                            <x-ui.badge variant="success" dot>Lulus / Disetujui</x-ui.badge>
                            <x-ui.badge variant="warning" dot>Menunggu Persetujuan</x-ui.badge>
                            <x-ui.badge variant="danger" dot>Ditolak / Drop Out</x-ui.badge>
                            <x-ui.badge variant="neutral">Draft</x-ui.badge>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Ukuran</h4>
                        <div class="flex items-center gap-3">
                            <x-ui.badge variant="primary" size="sm">Small Badge</x-ui.badge>
                            <x-ui.badge variant="primary" size="md">Medium Badge</x-ui.badge>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <!-- 3. Alerts Section -->
            <x-ui.card title="3. Alert Components (`<x-ui.alert>`)" subtitle="Pesan informasi, peringatan, atau notifikasi sistem">
                <div class="space-y-3">
                    <x-ui.alert type="info" title="Informasi Jadwal KRS" dismissible>
                        Pengisian Kartu Rencana Studi (KRS) Semester Ganjil dibuka hingga 30 September. Pastikan berkonsultasi dengan Dosen Pembimbing Akademik.
                    </x-ui.alert>

                    <x-ui.alert type="success" title="Pembayaran Berhasil Diverifikasi">
                        Tagihan UKT Anda telah lunas dan status registrasi semester ini aktif.
                    </x-ui.alert>

                    <x-ui.alert type="warning" title="Peringatan Batas Waktu">
                        Sisa waktu pengunggahan revisi skripsi kurang dari 3 hari kerja.
                    </x-ui.alert>

                    <x-ui.alert type="danger" title="Terjadi Kesalahan">
                        Format berkas yang diunggah tidak didukung. Harap unggah format PDF.
                    </x-ui.alert>
                </div>
            </x-ui.card>

            <!-- 4. Form Components Section -->
            <x-ui.card title="4. Form Inputs (`<x-ui.input>`, `<x-ui.select>`, `<x-ui.textarea>`)" subtitle="Elemen form dengan label terintegrasi, validasi error, dan hint text">
                <form onsubmit="event.preventDefault()" class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-ui.input
                            name="nim"
                            label="Nomor Induk Mahasiswa (NIM)"
                            placeholder="Contoh: 210101001"
                            required
                            hint="Masukkan 9 digit NIM terdaftar"
                        />

                        <x-ui.input
                            name="nama"
                            label="Nama Lengkap"
                            placeholder="Masukkan nama sesuai KTP"
                            required
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-ui.select name="jurusan" label="Program Studi" required placeholder="-- Pilih Program Studi --">
                            <x-ui.option value="ti">Teknik Informatika</x-ui.option>
                            <x-ui.option value="si">Sistem Informasi</x-ui.option>
                            <x-ui.option value="te">Teknik Elektro</x-ui.option>
                        </x-ui.select>

                        <x-ui.input
                            name="email"
                            label="Email Mahasiswa (Dengan State Error)"
                            value="email-salah@format"
                            error="Format email tidak valid atau sudah digunakan"
                        />
                    </div>

                    <x-ui.textarea
                        name="alamat"
                        label="Alamat Domisili"
                        placeholder="Alamat lengkap tempat tinggal saat ini..."
                        rows="3"
                        hint="Maksimal 255 karakter"
                    />

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <x-ui.button variant="ghost" type="reset">Reset</x-ui.button>
                        <x-ui.button variant="secondary" type="submit">Simpan Perubahan</x-ui.button>
                    </div>
                </form>
            </x-ui.card>

            <!-- 5. Table Section -->
            <x-ui.card title="5. Data Table (`<x-ui.table>`)" subtitle="Tabel responsif dengan hover otomatis, striping, header alignment, empty state, dan slot pagination">
                <div class="space-y-6">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Contoh 1: Tabel Data dengan Striped & Hover Otomatis</h4>
                        <x-ui.table
                            :headers="[
                                ['label' => 'NIM', 'width' => '130px'],
                                ['label' => 'Nama Mahasiswa'],
                                ['label' => 'Program Studi'],
                                ['label' => 'Status', 'align' => 'center'],
                                ['label' => 'Aksi', 'align' => 'right'],
                            ]"
                            striped
                        >
                            <tr>
                                <td class="font-mono text-xs font-semibold text-gray-700">220101001</td>
                                <td class="font-medium text-gray-900">Ahmad Fauzi</td>
                                <td class="text-gray-600">Teknik Informatika</td>
                                <td class="text-center">
                                    <x-ui.badge variant="success" dot size="sm">Aktif</x-ui.badge>
                                </td>
                                <td class="text-right">
                                    <x-ui.button variant="outline" size="sm">Detail</x-ui.button>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-mono text-xs font-semibold text-gray-700">220101002</td>
                                <td class="font-medium text-gray-900">Siti Nurhaliza</td>
                                <td class="text-gray-600">Sistem Informasi</td>
                                <td class="text-center">
                                    <x-ui.badge variant="warning" dot size="sm">Cuti</x-ui.badge>
                                </td>
                                <td class="text-right">
                                    <x-ui.button variant="outline" size="sm">Detail</x-ui.button>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-mono text-xs font-semibold text-gray-700">220101003</td>
                                <td class="font-medium text-gray-900">Budi Setiawan</td>
                                <td class="text-gray-600">Teknik Elektro</td>
                                <td class="text-center">
                                    <x-ui.badge variant="primary" dot size="sm">Reguler</x-ui.badge>
                                </td>
                                <td class="text-right">
                                    <x-ui.button variant="outline" size="sm">Detail</x-ui.button>
                                </td>
                            </tr>
                            <x-slot:footer>
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>Menampilkan 3 dari 3 data mahasiswa</span>
                                    <span>Halaman 1 dari 1</span>
                                </div>
                            </x-slot:footer>
                        </x-ui.table>
                    </div>

                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Contoh 2: Tampilan Empty State Otomatis</h4>
                        <x-ui.table
                            :headers="['Kode MK', 'Nama Mata Kuliah', 'SKS', 'Dosen Pengampu', 'Aksi']"
                            emptyTitle="Tidak Ada Jadwal Kuliah Ditemukan"
                            emptyDescription="Belum ada mata kuliah yang terjadwal untuk semester ini."
                        />
                    </div>
                </div>
            </x-ui.card>

            <!-- 6. Modal Dialog Section -->
            <x-ui.card title="6. Modal Dialog (`<x-ui.modal>`)" subtitle="Modal dialog native HTML5 dengan backdrop blur yang ringan dan elegan">
                <div class="flex items-center gap-3">
                    <x-ui.button variant="primary" onclick="document.getElementById('demo-modal').showModal()">
                        Buka Contoh Modal
                    </x-ui.button>
                </div>

                <x-ui.modal id="demo-modal" title="Konfirmasi Pengajuan KRS" maxWidth="md">
                    <p>Apakah Anda yakin ingin mengajukan Kartu Rencana Studi (KRS) untuk semester ini? Setelah diajukan, Anda tidak dapat mengubah daftar mata kuliah sebelum disetujui oleh Dosen Wali.</p>

                    <x-slot:footer>
                        <x-ui.button variant="ghost" size="sm" onclick="document.getElementById('demo-modal').close()">
                            Batal
                        </x-ui.button>
                        <x-ui.button variant="primary" size="sm" onclick="alert('KRS Diajukan!'); document.getElementById('demo-modal').close()">
                            Ya, Ajukan KRS
                        </x-ui.button>
                    </x-slot:footer>
                </x-ui.modal>
            </x-ui.card>

        </div>
    </div>
</x-layout.app>
