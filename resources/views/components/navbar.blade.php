@php
    // Breadcrumbs otomatis 100% diambil dari segmen URL aktif
    $segments = request()->segments();
    $dashboardUrl = Route::has('dashboard.index') ? route('dashboard.index') : url('/dashboard');

    $breadcrumbs = [];

    // Jika sedang di halaman dashboard / root
    if (empty($segments) || (count($segments) === 1 && $segments[0] === 'dashboard')) {
        $breadcrumbs[] = [
            'label' => 'Dashboard',
            'url' => null,
        ];
    } else {
        // Selalu sertakan Dashboard sebagai root breadcrumb
        $breadcrumbs[] = [
            'label' => 'Dashboard',
            'url' => $dashboardUrl,
        ];

        // Kamus label khusus singkatan/istilah umum di SIAKAD
        $customLabels = [
            'krs' => 'KRS',
            'khs' => 'KHS',
            'ukt' => 'UKT',
            'ui' => 'UI',
            'ui-showcase' => 'UI Showcase',
            'create' => 'Tambah Data',
            'edit' => 'Edit Data',
            'show' => 'Detail',
        ];

        $accumulated = '';
        foreach ($segments as $index => $segment) {
            if ($segment === 'dashboard') {
                continue;
            }

            $accumulated .= '/' . $segment;
            $isLast = ($index === array_key_last($segments));

            // Cek jika segmen berupa ID numerik (misal /mahasiswa/15)
            if (is_numeric($segment)) {
                $label = '#' . $segment;
            } else {
                $key = strtolower($segment);
                $label = $customLabels[$key] ?? ucwords(str_replace(['-', '_'], ' ', $segment));
            }

            $breadcrumbs[] = [
                'label' => $label,
                'url' => $isLast ? null : url($accumulated),
            ];
        }
    }

    // Dummy preview data notifikasi akademik
    $notifications = [
        [
            'id' => 1,
            'title' => 'Pengisian KRS Telah Dibuka',
            'message' => 'Masa pengisian KRS Semester Ganjil dibuka s/d 14 Desember 2026.',
            'time' => '10 menit yang lalu',
            'unread' => true,
            'icon' => 'calendar-check',
            'icon_bg' => 'bg-primary/10 text-primary',
        ],
        [
            'id' => 2,
            'title' => 'Pembayaran UKT Terverifikasi',
            'message' => 'Status pembayaran UKT Mahasiswa telah tervalidasi otomatis.',
            'time' => '1 jam yang lalu',
            'unread' => true,
            'icon' => 'circle-check',
            'icon_bg' => 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400',
        ],
        [
            'id' => 3,
            'title' => 'Nilai Semester Diterbitkan',
            'message' => 'Nilai akhir untuk mata kuliah Pemrograman Web telah diunggah.',
            'time' => 'Kemarin',
            'unread' => false,
            'icon' => 'file-text',
            'icon_bg' => 'bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400',
        ],
    ];

    $unreadCount = count(array_filter($notifications, fn($n) => $n['unread']));
@endphp

<header {{ $attributes->merge(['class' => 'h-16 bg-white dark:bg-gray-900 border-b border-gray-200/80 dark:border-gray-800 px-4 sm:px-6 flex items-center justify-between shrink-0 select-none transition-colors duration-200 z-30 sticky top-0']) }}>
    <!-- Bagian Kiri: Sidebar Toggle & Breadcrumb Path -->
    <div class="flex items-center gap-2 sm:gap-3 min-w-0">
        <!-- Tombol Toggle Collapse / Expand Sidebar -->
        <button type="button"
                id="navbar-sidebar-toggle"
                onclick="window.toggleSidebar()"
                title="Ciutkan / Rentangkan Sidebar"
                class="p-2 -ml-1.5 rounded-xl text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-slate-100 dark:hover:bg-gray-800 transition-colors cursor-pointer focus:outline-none shrink-0">
            <x-lucide-panel-left class="w-5 h-5" />
        </button>

        <nav class="flex items-center min-w-0" aria-label="Breadcrumb">
            <ol class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm">
                @foreach ($breadcrumbs as $crumb)
                    @php
                        $isLast = $loop->last;
                    @endphp

                    <li class="inline-flex items-center gap-1.5 sm:gap-2 min-w-0">
                        @if (!$loop->first)
                            <x-lucide-chevron-right class="w-3.5 h-3.5 text-gray-400 dark:text-gray-600 shrink-0" />
                        @endif

                        @if ($isLast || empty($crumb['url']))
                            <span class="font-semibold text-gray-800 dark:text-gray-100 truncate max-w-[160px] sm:max-w-xs" aria-current="page">
                                {{ $crumb['label'] }}
                            </span>
                        @else
                            <a href="{{ $crumb['url'] }}" class="inline-flex items-center gap-1.5 text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors font-medium truncate max-w-[120px] sm:max-w-none">
                                @if ($loop->first)
                                    <x-lucide-home class="w-4 h-4 shrink-0 text-gray-400 dark:text-gray-500" />
                                @endif
                                <span class="truncate">{{ $crumb['label'] }}</span>
                            </a>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>

    <!-- Bagian Kanan: Notifikasi & Dark Mode Toggle -->
    <div class="flex items-center gap-1.5 sm:gap-2.5">
        <!-- 1. Dropdown Notifikasi -->
        <div class="relative" id="notification-wrapper">
            <button type="button"
                    id="notification-button"
                    aria-expanded="false"
                    aria-haspopup="true"
                    title="Notifikasi"
                    class="relative p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-slate-100 dark:hover:bg-gray-800 transition-colors cursor-pointer focus:outline-none">
                <x-lucide-bell class="w-5 h-5" />

                <!-- Badge Indikator Unread -->
                @if ($unreadCount > 0)
                    <span id="notification-dot" class="absolute top-1.5 right-1.5 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                @endif
            </button>

            <!-- Dropdown Menu Box -->
            <div id="notification-menu"
                 class="hidden fixed inset-x-3 top-16 mt-2 sm:inset-auto sm:absolute sm:right-0 sm:top-full max-w-sm sm:max-w-none mx-auto sm:mx-0 w-auto sm:w-96 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200/90 dark:border-gray-800 overflow-hidden z-50 transition-all duration-200">
                <!-- Dropdown Header -->
                <div class="px-4 py-3.5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between bg-slate-50/60 dark:bg-gray-800/40">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Notifikasi</h3>
                        <span id="notification-count-badge" class="px-2 py-0.5 text-[11px] font-semibold rounded-full bg-primary/10 text-primary border border-primary/20">
                            {{ $unreadCount }} Baru
                        </span>
                    </div>
                    <button type="button"
                            id="mark-all-read-btn"
                            class="text-[11px] font-medium text-primary hover:underline cursor-pointer">
                        Tandai dibaca
                    </button>
                </div>

                <!-- Dropdown List Items -->
                <div class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800 scrollbar-thin">
                    @forelse ($notifications as $notif)
                        <div class="notification-item p-3.5 hover:bg-slate-50 dark:hover:bg-gray-800/60 transition-colors flex gap-3 cursor-pointer group {{ $notif['unread'] ? 'bg-primary/[0.02] dark:bg-primary/[0.03]' : '' }}"
                             data-id="{{ $notif['id'] }}">
                            <!-- Icon Box -->
                            <div class="w-9 h-9 rounded-xl {{ $notif['icon_bg'] }} shrink-0 flex items-center justify-center">
                                <x-dynamic-component :component="'lucide-' . $notif['icon']" class="w-4 h-4" />
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-1">
                                    <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 group-hover:text-primary transition-colors leading-snug">
                                        {{ $notif['title'] }}
                                    </p>
                                    @if ($notif['unread'])
                                        <span class="unread-indicator w-2 h-2 rounded-full bg-primary shrink-0 mt-1"></span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 mt-0.5 leading-relaxed">
                                    {{ $notif['message'] }}
                                </p>
                                <span class="text-[10px] text-gray-400 dark:text-gray-500 mt-1 block">
                                    {{ $notif['time'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-gray-400">
                            Tidak ada notifikasi saat ini
                        </div>
                    @endforelse
                </div>

                <!-- Dropdown Footer -->
                <div class="px-4 py-2.5 border-t border-gray-100 dark:border-gray-800 text-center bg-slate-50/40 dark:bg-gray-800/20">
                    <a href="{{ url('/notifikasi') }}" class="text-xs font-semibold text-primary hover:underline">
                        Lihat Semua Notifikasi
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. Dark Mode Toggle Switch -->
        <button type="button"
                id="theme-toggle"
                aria-label="Toggle Light and Dark Mode"
                title="Ganti Tema (Light/Dark)"
                class="p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-slate-100 dark:hover:bg-gray-800 transition-colors cursor-pointer focus:outline-none">
            <!-- Icon Matahari (Tampil saat Dark Mode) -->
            <x-lucide-sun class="w-5 h-5 hidden dark:block text-gray-400 hover:text-primary transition-transform duration-200 hover:rotate-45" />

            <!-- Icon Bulan (Tampil saat Light Mode) -->
            <x-lucide-moon class="w-5 h-5 block dark:hidden text-gray-600 hover:text-primary transition-transform duration-200 hover:-rotate-12" />
        </button>
    </div>
</header>

<!-- Script Interaktif Navbar: Toggle Notifikasi & Dark Mode -->
<script>
    (function () {
        // --- 1. Logika Toggle Notifikasi ---
        const notifWrapper = document.getElementById('notification-wrapper');
        const notifButton = document.getElementById('notification-button');
        const notifMenu = document.getElementById('notification-menu');
        const notifDot = document.getElementById('notification-dot');
        const notifBadge = document.getElementById('notification-count-badge');
        const markAllReadBtn = document.getElementById('mark-all-read-btn');

        if (notifButton && notifMenu) {
            notifButton.addEventListener('click', function (e) {
                e.stopPropagation();
                const isHidden = notifMenu.classList.contains('hidden');
                if (isHidden) {
                    notifMenu.classList.remove('hidden');
                    notifButton.setAttribute('aria-expanded', 'true');
                } else {
                    notifMenu.classList.add('hidden');
                    notifButton.setAttribute('aria-expanded', 'false');
                }
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', function (e) {
                if (notifWrapper && !notifWrapper.contains(e.target)) {
                    notifMenu.classList.add('hidden');
                    notifButton.setAttribute('aria-expanded', 'false');
                }
            });

            // Tutup dengan tombol Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !notifMenu.classList.contains('hidden')) {
                    notifMenu.classList.add('hidden');
                    notifButton.setAttribute('aria-expanded', 'false');
                }
            });

            // Tandai semua dibaca
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    document.querySelectorAll('.unread-indicator').forEach(el => el.remove());
                    if (notifDot) notifDot.remove();
                    if (notifBadge) {
                        notifBadge.textContent = '0 Baru';
                        notifBadge.classList.replace('text-primary', 'text-gray-400');
                        notifBadge.classList.replace('bg-primary/10', 'bg-gray-100');
                    }
                });
            }
        }

        // --- 2. Logika Toggle Light / Dark Mode ---
        const themeToggle = document.getElementById('theme-toggle');

        function updateTheme(isDark) {
            if (isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                const isDark = document.documentElement.classList.contains('dark');
                updateTheme(!isDark);
            });
        }
    })();
</script>
