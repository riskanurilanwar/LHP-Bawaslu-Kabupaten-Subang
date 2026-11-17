
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">

    <!-- Header & Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-red-950 p-6 sm:p-8 text-white shadow-xl border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-500/20 text-red-300 border border-red-500/30 text-xs font-semibold mb-3">
                    <i class="fa-solid fa-shield-halved text-[11px]"></i>
                    <span>Hak Akses: Administrator</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Selamat Datang, <?= esc(session()->get('nama')) ?>
                </h1>
                <p class="text-slate-300 text-sm mt-1.5 max-w-2xl leading-relaxed">
                    Pusat kendali dan administrasi pengguna serta pemantauan Laporan Hasil Pengawasan (LHP) Bawaslu Kabupaten Subang.
                </p>
            </div>

            <div class="flex flex-wrap gap-2.5 shrink-0">
                <a href="<?= base_url('lhp/tambah') ?>"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-red-950/40 hover:from-red-700 hover:to-red-800 transition-all duration-150">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Buat LHP</span>
                </a>
                <a href="<?= base_url('kelola-pengguna') ?>"
                   class="inline-flex items-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-150 backdrop-blur-xs">
                    <i class="fa-solid fa-users text-xs"></i>
                    <span>Kelola Pengguna</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Pengguna -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-users-gear text-red-700"></i>
                Statistik Akun Pengguna
            </h2>
            <span class="text-xs text-slate-500">Terdaftar dalam sistem</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            <!-- Total Pengguna -->
            <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Total Pengguna
                        </p>
                        <h3 class="text-3xl font-extrabold text-slate-900 mt-2">
                            <?= esc($totalPengguna) ?>
                        </h3>
                        <p class="text-[11px] text-slate-400 mt-1">Seluruh akun terdaftar</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center text-xl shadow-xs">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>
            </div>

            <!-- Pengawas -->
            <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Total Pengawas
                        </p>
                        <h3 class="text-3xl font-extrabold text-blue-600 mt-2">
                            <?= esc($totalPengawas) ?>
                        </h3>
                        <p class="text-[11px] text-slate-400 mt-1">Petugas lapangan & staff</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-xs">
                        <i class="fa-solid fa-id-badge"></i>
                    </div>
                </div>
            </div>

            <!-- Pimpinan -->
            <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Total Pimpinan
                        </p>
                        <h3 class="text-3xl font-extrabold text-amber-600 mt-2">
                            <?= esc($totalPimpinan) ?>
                        </h3>
                        <p class="text-[11px] text-slate-400 mt-1">Akses rekap & telaah</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-xs">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                </div>
            </div>

            <!-- Admin -->
            <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Total Admin
                        </p>
                        <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">
                            <?= esc($totalAdmin) ?>
                        </h3>
                        <p class="text-[11px] text-slate-400 mt-1">Pengelola sistem utama</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-xs">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Statistik LHP -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        <div class="bg-gradient-to-br from-white to-slate-50/80 rounded-2xl shadow-xs border border-slate-200/80 p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold mb-2">
                        <i class="fa-solid fa-database text-[10px]"></i>
                        <span>Seluruh Database</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                        Total Laporan Hasil Pengawasan
                    </p>
                    <h3 class="text-4xl font-black text-slate-900 mt-2">
                        <?= esc($totalLhp) ?>
                    </h3>
                    <p class="text-xs text-slate-500 mt-2">
                        Jumlah seluruh laporan pengawasan yang tersimpan dalam sistem.
                    </p>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl shadow-inner shrink-0">
                    <i class="fa-solid fa-folder-tree"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50/80 rounded-2xl shadow-xs border border-slate-200/80 p-6 hover:shadow-md transition-all duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-red-50 text-red-700 text-xs font-semibold mb-2">
                        <i class="fa-solid fa-user-pen text-[10px]"></i>
                        <span>Laporan Mandiri</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                        Total LHP Saya
                    </p>
                    <h3 class="text-4xl font-black text-red-700 mt-2">
                        <?= esc($totalLhpSaya) ?>
                    </h3>
                    <p class="text-xs text-slate-500 mt-2">
                        Jumlah laporan pengawasan yang dibuat oleh akun Administrator Anda.
                    </p>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-2xl shadow-inner shrink-0">
                    <i class="fa-solid fa-file-signature"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabel LHP Terbaru Milik Admin -->
    <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">

        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="font-bold text-base sm:text-lg text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-slate-500"></i>
                    LHP Terbaru Saya
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Daftar laporan hasil pengawasan terkini yang dibuat oleh akun Anda.
                </p>
            </div>

            <a href="<?= base_url('lhp') ?>" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1 self-start sm:self-auto">
                <span>Buka Semua LHP</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50/80 text-slate-600 text-xs font-bold uppercase tracking-wider border-b border-slate-100">

                    <tr>
                        <th class="text-left px-5 py-3.5">Nomor LHP</th>
                        <th class="text-left px-5 py-3.5">Tahapan</th>
                        <th class="text-left px-5 py-3.5">Waktu Pengawasan</th>
                        <th class="text-left px-5 py-3.5">Status</th>
                        <th class="text-center px-5 py-3.5">Aksi</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($lhpTerbaruSaya)) : ?>

                        <?php foreach ($lhpTerbaruSaya as $lhp) : ?>

                            <tr class="hover:bg-slate-50/70 transition-colors">

                                <td class="px-5 py-4 font-semibold text-slate-900">
                                    <?= esc($lhp['nomor_lhp'] ?? 'Belum memiliki nomor') ?>
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    <?= esc($lhp['tahapan'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-4 text-slate-600 text-xs">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        <?= !empty($lhp['waktu_pengawasan'])
                                            ? esc(date('d-m-Y H:i', strtotime($lhp['waktu_pengawasan'])))
                                            : '-' ?>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <?php $isDikirim = strtolower($lhp['status'] ?? '') === 'dikirim'; ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                        <?= $isDikirim
                                            ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20'
                                            : 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20' ?>">
                                        <span class="w-1.5 h-1.5 rounded-full <?= $isDikirim ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
                                        <?= esc($lhp['status'] ?? '-') ?>
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <a href="<?= base_url('lhp/detail/' . $lhp['id']) ?>"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold text-xs transition-colors">
                                        <i class="fa-regular fa-eye text-xs"></i>
                                        <span>Detail</span>
                                    </a>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else : ?>

                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="max-w-xs mx-auto text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl mx-auto mb-3">
                                        <i class="fa-regular fa-folder-open"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Belum ada LHP</p>
                                    <p class="text-xs text-slate-400 mt-1">Anda belum membuat laporan hasil pengawasan.</p>
                                    <a href="<?= base_url('lhp/tambah') ?>" class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-red-700 hover:text-red-800">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>Buat LHP Sekarang</span>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?= $this->endSection() ?>
