
<?php

$role = session()->get('role');

$namaRole = [
    'admin'    => 'Administrator',
    'pimpinan' => 'Pimpinan',
    'pengawas' => 'Pengawas / Staff',
];

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

<aside class="w-64 bg-slate-900 text-white
              hidden md:flex flex-col min-h-screen">

    <!-- Logo -->
    <div class="px-6 py-6 border-b border-slate-700">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 bg-red-600
                        rounded-xl flex items-center
                        justify-center font-bold text-lg">

                LHP

            </div>

            <div>

                <h1 class="font-bold text-lg">
                    Bawaslu
                </h1>

                <p class="text-xs text-slate-400">
                    Kabupaten Subang
                </p>

            </div>

        </div>

    </div>

    <!-- Informasi Role -->
    <div class="px-6 py-4">

        <p class="text-xs text-slate-400 uppercase
                  tracking-wider">

            Menu <?= esc($namaRole[$role] ?? 'Pengguna') ?>

        </p>

    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 space-y-2">

        <?php foreach ($menu as $item) : ?>

            <?php
                $isActive = current_url() === base_url(
                    ltrim($item['url'], '/')
                );
            ?>

            <a
                href="<?= base_url(ltrim($item['url'], '/')) ?>"
                class="flex items-center gap-3 px-4 py-3
                       rounded-lg transition

                       <?= $isActive
                            ? 'bg-red-600 text-white'
                            : 'text-slate-300 hover:bg-slate-800'
                       ?>"
            >

                <i class="<?= esc($item['icon']) ?> w-5 text-center text-lg" aria-hidden="true"></i>

                <span class="text-sm font-medium">
                    <?= esc($item['label']) ?>
                </span>

            </a>

        <?php endforeach; ?>

    </nav>

    <!-- Footer Sidebar -->
    <div class="px-6 py-4 border-t border-slate-700">

        <p class="text-xs text-slate-400">
            Sistem Informasi LHP
        </p>

        <p class="text-xs text-slate-500 mt-1">
            Versi 1.0
        </p>

    </div>

</aside>
