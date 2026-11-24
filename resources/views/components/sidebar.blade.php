@php
    $menuGroups = [
        [
            'group' => 'Utama',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'layout-dashboard',
                    'url' => Route::has('dashboard.index') ? route('dashboard.index') : url('/dashboard'),
                    'active' => request()->routeIs('dashboard.*') || request()->is('dashboard'),
                    'badge' => null,
                ],
            ],
        ],
        [
            'group' => 'Akademik',
            'items' => [
                [
                    'label' => 'Siswa',
                    'icon' => 'users',
                    'url' => url('/siswa'),
                    'active' => request()->is('siswa*'),
                    'badge' => null,
                ]
            ],
        ],
        [
            'group' => 'Administrasi & Keuangan',
            'items' => [
                [
                    'label' => 'Laporan Akademik',
                    'icon' => 'line-chart',
                    'url' => url('/laporan'),
                    'active' => request()->is('laporan*'),
                    'badge' => null,
                ]
            ],
        ],
        [
            'group' => 'Sistem & Pengaturan',
            'items' => [
                [
                    'label' => 'Pengaturan',
                    'icon' => 'settings',
                    'url' => url('/pengaturan'),
                    'active' => request()->is('pengaturan*'),
                    'badge' => null,
                ],
            ],
        ],
    ];

    $userName = auth()->user()->name ?? 'Administrator';
    $userRole = auth()->user()->role ?? (auth()->user()->email ?? 'Akademik');
    $userInitials = strtoupper(substr($userName, 0, 2));
@endphp

<!-- Mobile Backdrop Overlay -->
<div id="sidebar-backdrop"
     onclick="window.closeMobileSidebar()"
     class="fixed inset-0 bg-black/40 backdrop-blur-xs z-40 hidden md:hidden transition-opacity"></div>

<!-- Sidebar Container -->
<aside id="main-sidebar"
       {{ $attributes->merge(['class' => 'w-64 bg-white dark:bg-gray-900 border-r border-gray-200/80 dark:border-gray-800 flex flex-col h-screen shrink-0 font-sans select-none shadow-xs transition-all duration-300 ease-in-out fixed md:static inset-y-0 left-0 z-50 -translate-x-full md:translate-x-0']) }}>

    <!-- Header / Brand Logo -->
    <div id="sidebar-header" class="h-16 flex items-center justify-between px-4 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 transition-colors">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group min-w-0" title="SIAKAD Portal Akademik">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-xs group-hover:bg-primary/90 transition-colors duration-200 shrink-0">
                <x-lucide-graduation-cap class="w-6 h-6" />
            </div>
            <div class="flex flex-col sidebar-text transition-opacity duration-200">
                <span class="text-base font-bold text-gray-900 dark:text-white tracking-tight leading-none group-hover:text-primary transition-colors">
                    SIAKAD
                </span>
                <span class="text-[11px] font-medium text-gray-400 dark:text-gray-500 leading-tight mt-1">
                    Portal Akademik
                </span>
            </div>
        </a>

        <!-- Tombol Tutup Khusus Layar Mobile -->
        <button type="button"
                onclick="window.closeMobileSidebar()"
                title="Tutup Menu"
                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 md:hidden flex items-center justify-center">
            <x-lucide-chevron-left class="w-5 h-5" />
        </button>
    </div>

    <!-- Navigation Menu List (Looping dari $menuGroups) -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-6 scrollbar-thin scrollbar-thumb-gray-200 dark:scrollbar-thumb-gray-800 bg-white dark:bg-gray-900 transition-colors">
        @foreach ($menuGroups as $group)
            <div>
                <!-- Group Header Title (Expanded) -->
                @if (!empty($group['group']))
                    <p class="sidebar-text px-3 mb-2 text-[11px] font-bold tracking-wider uppercase text-gray-400 dark:text-gray-500">
                        {{ $group['group'] }}
                    </p>
                    <!-- Divider saat sidebar dalam posisi collapsed -->
                    <div class="sidebar-divider hidden my-2 mx-1 border-t border-gray-100 dark:border-gray-800"></div>
                @endif

                <!-- Menu Items -->
                <ul class="space-y-1">
                    @foreach ($group['items'] as $item)
                        @php
                            $isActive = $item['active'] ?? false;
                            $hasChildren = !empty($item['children']);
                        @endphp

                        <li>
                            <a href="{{ $item['url'] ?? '#' }}"
                               title="{{ $item['label'] }}"
                               class="sidebar-nav-item group flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 ease-in-out {{ $isActive
                                   ? 'bg-primary text-white shadow-xs font-semibold'
                                   : 'text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary hover:bg-primary/5 dark:hover:bg-primary/10' }}">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="{{ $isActive ? 'text-white' : 'text-gray-400 dark:text-gray-500 group-hover:text-primary transition-colors' }}">
                                        <x-dynamic-component :component="'lucide-' . $item['icon']" class="w-5 h-5 shrink-0" />
                                    </div>
                                    <span class="sidebar-text truncate">{{ $item['label'] }}</span>
                                </div>

                                <!-- Optional Badge -->
                                @if (!empty($item['badge']))
                                    @php
                                        $badgeVariant = $item['badge_variant'] ?? 'primary';
                                        $badgeClasses = match($badgeVariant) {
                                            'success' => $isActive ? 'bg-white/20 text-white' : 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800',
                                            'light' => $isActive ? 'bg-white/20 text-white' : 'bg-primary/10 text-primary border border-primary/20',
                                            'warning' => $isActive ? 'bg-white/20 text-white' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800',
                                            'danger' => $isActive ? 'bg-white/20 text-white' : 'bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800',
                                            default => $isActive ? 'bg-white/20 text-white' : 'bg-primary/10 text-primary border border-primary/20',
                                        };
                                    @endphp
                                    <span class="sidebar-text text-[11px] font-semibold px-2 py-0.5 rounded-full {{ $badgeClasses }}">
                                        {{ $item['badge'] }}
                                    </span>
                                @endif
                            </a>

                            <!-- Optional Submenu Children -->
                            @if ($hasChildren)
                                <ul class="sidebar-text mt-1 ml-6 pl-2.5 border-l border-gray-100 dark:border-gray-800 space-y-1">
                                    @foreach ($item['children'] as $child)
                                        @php
                                            $isChildActive = $child['active'] ?? false;
                                        @endphp
                                        <li>
                                            <a href="{{ $child['url'] ?? '#' }}"
                                               title="{{ $child['label'] }}"
                                               class="block px-2.5 py-1.5 text-xs rounded-lg transition-colors {{ $isChildActive
                                                   ? 'text-primary font-semibold bg-primary/10'
                                                   : 'text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary hover:bg-primary/5 dark:hover:bg-primary/10' }}">
                                                {{ $child['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <!-- Footer / User Profile & Logout -->
    <div class="p-3 border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 transition-colors">
        <div id="sidebar-profile-card" class="flex items-center justify-between p-2 rounded-xl bg-white dark:bg-gray-800/60 border border-gray-100 dark:border-gray-800 shadow-2xs">
            <div class="flex items-center gap-2.5 min-w-0" title="{{ $userName }} ({{ $userRole }})">
                <div class="w-9 h-9 rounded-full bg-primary/10 border border-primary/20 text-primary font-semibold flex items-center justify-center text-xs shrink-0">
                    {{ $userInitials }}
                </div>
                <div class="sidebar-text min-w-0 flex-1">
                    <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate leading-tight">
                        {{ $userName }}
                    </p>
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 truncate leading-tight mt-0.5">
                        {{ $userRole }}
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout.post') }}" class="sidebar-text m-0">
                @csrf
                <button type="submit"
                        title="Logout"
                        class="p-2 text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 rounded-lg transition-colors cursor-pointer">
                    <x-lucide-log-out class="w-4 h-4" />
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- JavaScript Pengatur Collapse/Expand & Responsif Mobile -->
<script>
    (function () {
        const sidebar = document.getElementById('main-sidebar');
        const backdrop = document.getElementById('sidebar-backdrop');
        const header = document.getElementById('sidebar-header');
        const profileCard = document.getElementById('sidebar-profile-card');

        // Fungsi apply status collapsed / expanded pada desktop
        function setSidebarCollapsedState(isCollapsed) {
            if (!sidebar) return;

            if (isCollapsed) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                sidebar.setAttribute('data-collapsed', 'true');

                // Sembunyikan elemen teks
                sidebar.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));

                // Posisikan icon di tengah
                sidebar.querySelectorAll('.sidebar-nav-item').forEach(el => {
                    el.classList.add('justify-center', 'px-0');
                    el.classList.remove('justify-between', 'px-3');
                });

                // Munculkan garis pemisah kategori
                sidebar.querySelectorAll('.sidebar-divider').forEach(el => el.classList.remove('hidden'));

                if (header) {
                    header.classList.add('justify-center', 'px-2');
                    header.classList.remove('justify-between', 'px-4');
                }

                if (profileCard) {
                    profileCard.classList.add('justify-center', 'p-1.5');
                    profileCard.classList.remove('justify-between', 'p-2');
                }

                localStorage.setItem('sidebar-collapsed', 'true');
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                sidebar.setAttribute('data-collapsed', 'false');

                // Tampilkan elemen teks
                sidebar.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));

                // Kembalikan posisi item ke layout normal
                sidebar.querySelectorAll('.sidebar-nav-item').forEach(el => {
                    el.classList.remove('justify-center', 'px-0');
                    el.classList.add('justify-between', 'px-3');
                });

                // Sembunyikan garis pemisah kategori
                sidebar.querySelectorAll('.sidebar-divider').forEach(el => el.classList.add('hidden'));

                if (header) {
                    header.classList.remove('justify-center', 'px-2');
                    header.classList.add('justify-between', 'px-4');
                }

                if (profileCard) {
                    profileCard.classList.remove('justify-center', 'p-1.5');
                    profileCard.classList.add('justify-between', 'p-2');
                }

                localStorage.setItem('sidebar-collapsed', 'false');
            }
        }

        // Global toggle function
        window.toggleSidebar = function () {
            if (window.innerWidth < 768) {
                // Di layar mobile: buka/tutup drawer
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    window.closeMobileSidebar();
                } else {
                    window.openMobileSidebar();
                }
            } else {
                // Di layar desktop: collapse / expand
                const isCollapsed = sidebar.getAttribute('data-collapsed') === 'true';
                setSidebarCollapsedState(!isCollapsed);
            }
        };

        window.openMobileSidebar = function () {
            if (!sidebar) return;
            sidebar.classList.remove('-translate-x-full');
            if (backdrop) backdrop.classList.remove('hidden');
        };

        window.closeMobileSidebar = function () {
            if (!sidebar) return;
            sidebar.classList.add('-translate-x-full');
            if (backdrop) backdrop.classList.add('hidden');
        };

        // Inisialisasi awal saat halaman dibuka
        const storedCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
        if (window.innerWidth >= 768 && storedCollapsed) {
            setSidebarCollapsedState(true);
        }
    })();
</script>
