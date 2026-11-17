
<?php

$role = session()->get('role');

$namaRole = [
    'admin'    => 'Administrator',
    'pimpinan' => 'Pimpinan',
    'pengawas' => 'Pengawas / Staff',
];

$roleBadges = [
    'admin'    => ['bg' => 'bg-red-500/10', 'text' => 'text-red-400', 'border' => 'border-red-500/20', 'icon' => 'fa-shield-halved'],
    'pimpinan' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-400', 'border' => 'border-amber-500/20', 'icon' => 'fa-user-tie'],
    'pengawas' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'border' => 'border-blue-500/20', 'icon' => 'fa-id-badge'],
];

$roleBadge = $roleBadges[$role] ?? ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-400', 'border' => 'border-slate-500/20', 'icon' => 'fa-user'];

$menu = [];

if ($role === 'pengawas') {

    $menu = [
        [
            'label' => 'Dashboard',
            'url'   => '/dashboard/pengawas',
            'icon'  => 'fa-solid fa-house',
        ],
        [
            'label' => 'Kelola LHP',
            'url'   => '/lhp',
            'icon'  => 'fa-solid fa-file-lines',
        ],
        [
            'label' => 'Profil Saya',
            'url'   => '/profil',
            'icon'  => 'fa-solid fa-user',
        ],
    ];

} elseif ($role === 'pimpinan') {

    $menu = [
        [
            'label' => 'Dashboard',
            'url'   => '/dashboard/pimpinan',
            'icon'  => 'fa-solid fa-house',
        ],
        [
            'label' => 'Kelola Penugasan',
            'url'   => '/kelola-penugasan',
            'icon'  => 'fa-solid fa-clipboard-list',
        ],
        [
            'label' => 'Kelola LHP',
            'url'   => '/lhp',
            'icon'  => 'fa-solid fa-file-lines',
        ],
        [
            'label' => 'Rekapitulasi LHP',
            'url'   => '/rekapitulasi-lhp',
            'icon'  => 'fa-solid fa-chart-column',
        ],
        [
            'label' => 'Profil Saya',
            'url'   => '/profil',
            'icon'  => 'fa-solid fa-user',
        ],
    ];

} elseif ($role === 'admin') {

    $menu = [
        [
            'label' => 'Dashboard',
            'url'   => '/dashboard/admin',
            'icon'  => 'fa-solid fa-house',
        ],
        [
            'label' => 'Kelola Pengguna',
            'url'   => '/kelola-pengguna',
            'icon'  => 'fa-solid fa-users',
        ],
        [
            'label' => 'Template Dokumen',
            'url'   => '/kelola-template-lhp',
            'icon'  => 'fa-solid fa-file-pen',
        ],
        [
            'label' => 'Kelola LHP',
            'url'   => '/lhp',
            'icon'  => 'fa-solid fa-file-lines',
        ],
        [
            'label' => 'Profil Saya',
            'url'   => '/profil',
            'icon'  => 'fa-solid fa-user',
        ],
    ];

}

?>

<!-- Mobile Sidebar Overlay Backdrop -->
<div
    id="sidebarOverlay"
    onclick="toggleSidebar()"
    class="fixed inset-0 z-40 bg-slate-950/70 backdrop-blur-xs transition-opacity duration-300 opacity-0 pointer-events-none md:hidden"
    aria-hidden="true"
></div>

<!-- Main Aside Navigation -->
<aside
    id="appSidebar"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white
           flex flex-col min-h-screen border-r border-slate-800/80 transition-transform duration-300 ease-in-out
           -translate-x-full md:translate-x-0 md:static md:w-64 lg:w-72 shadow-2xl md:shadow-none"
>

    <!-- Header & Logo -->
    <div class="px-6 py-5 border-b border-slate-800/80 bg-slate-950/40">

        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3.5">

                <!-- Logo Badge -->
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-red-600 to-red-800
                            flex items-center justify-center font-extrabold text-white text-lg
                            shadow-lg shadow-red-950/60 ring-2 ring-red-500/20">
                    <span class="tracking-tight">LHP</span>
                </div>

                <div>
                    <div class="flex items-center gap-1.5">
                        <h1 class="font-extrabold text-lg tracking-wider text-white">
                            BAWASLU
                        </h1>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md bg-red-500/20 text-red-400 border border-red-500/30">
                            KAB
                        </span>
                    </div>

                    <p class="text-xs font-medium text-slate-400 tracking-wide">
                        Kabupaten Subang
                    </p>
                </div>

            </div>

            <!-- Mobile Close Button -->
            <button
                type="button"
                onclick="toggleSidebar()"
                class="md:hidden text-slate-400 hover:text-white p-2 rounded-lg hover:bg-slate-800/60 focus:outline-none"
                aria-label="Tutup Menu"
            >
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

        </div>

    </div>

    <!-- Informasi Akun Aktif & Role -->
    <div class="px-5 py-4 border-b border-slate-800/60 bg-slate-950/20">
        <div class="rounded-xl border <?= esc($roleBadge['border']) ?> <?= esc($roleBadge['bg']) ?> p-3 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-slate-900/80 flex items-center justify-center text-sm <?= esc($roleBadge['text']) ?>">
                <i class="fa-solid <?= esc($roleBadge['icon']) ?>"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[11px] font-semibold uppercase tracking-wider <?= esc($roleBadge['text']) ?>">
                    <?= esc($namaRole[$role] ?? 'Pengguna') ?>
                </p>
                <p class="text-xs text-slate-300 font-medium truncate">
                    <?= esc(session()->get('nama')) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu Items -->
    <div class="px-5 pt-3 pb-2">
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
            Menu Utama
        </p>
    </div>

    <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto">

        <?php foreach ($menu as $item) : ?>

            <?php
                $itemCleanUrl = ltrim($item['url'], '/');
                $isDashboardItem = str_contains($item['url'], 'dashboard');
                $isCurrentExact = current_url() === base_url($itemCleanUrl);

                if ($isDashboardItem) {
                    $isActive = $isCurrentExact;
                } else {
                    $isActive = $isCurrentExact || str_starts_with(current_url(), base_url($itemCleanUrl));
                }
            ?>

            <a
                href="<?= base_url($itemCleanUrl) ?>"
                class="group relative flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150

                       <?= $isActive
                            ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-md shadow-red-950/40 ring-1 ring-red-400/30'
                            : 'text-slate-300 hover:text-white hover:bg-slate-800/70'
                       ?>"
            >

                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-base transition-colors
                                 <?= $isActive ? 'bg-white/20 text-white' : 'bg-slate-800/60 text-slate-400 group-hover:text-white group-hover:bg-slate-800' ?>">
                        <i class="<?= esc($item['icon']) ?>" aria-hidden="true"></i>
                    </span>

                    <span class="tracking-wide">
                        <?= esc($item['label']) ?>
                    </span>
                </div>

                <?php if ($isActive) : ?>
                    <span class="w-1.5 h-1.5 rounded-full bg-white shadow-xs"></span>
                <?php else : ?>
                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                <?php endif; ?>

            </a>

        <?php endforeach; ?>

    </nav>

    <!-- Footer Sidebar -->
    <div class="p-4 border-t border-slate-800/80 bg-slate-950/50">
        <div class="rounded-xl bg-slate-900/80 border border-slate-800 p-3">
            <div class="flex items-center justify-between mb-1">
                <span class="text-xs font-semibold text-slate-300">Sistem LHP</span>
                <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Aktif
                </span>
            </div>
            <p class="text-[11px] text-slate-400">
                Pengawasan Pemilu Terintegrasi
            </p>
        </div>
    </div>

</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('appSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (!sidebar || !overlay) return;

        const isClosed = sidebar.classList.contains('-translate-x-full');
        if (isClosed) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            document.body.classList.add('overflow-hidden', 'md:overflow-auto');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden', 'md:overflow-auto');
        }
    }
</script>
