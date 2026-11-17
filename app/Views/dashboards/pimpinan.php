
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-8">

    <!-- Header & Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-red-950 p-6 sm:p-8 text-white shadow-xl border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-semibold mb-3">
                    <i class="fa-solid fa-user-tie text-[11px]"></i>
                    <span>Hak Akses: Pimpinan Bawaslu</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Dashboard Pimpinan
                </h1>
                <p class="text-slate-300 text-sm mt-1.5 max-w-2xl leading-relaxed">
                    Ringkasan eksekutif dan pemantauan menyeluruh pelaksanaan pengawasan pemilu di Kabupaten Subang.
                </p>
            </div>

            <div class="flex flex-wrap gap-2.5 shrink-0">
                <a href="<?= base_url('rekapitulasi-lhp') ?>"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-red-950/40 hover:from-red-700 hover:to-red-800 transition-all duration-150">
                    <i class="fa-solid fa-chart-column text-xs"></i>
                    <span>Rekapitulasi LHP</span>
                </a>
                <a href="<?= base_url('kelola-penugasan') ?>"
                   class="inline-flex items-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 px-4 py-2.5 text-sm font-semibold text-white transition-all duration-150 backdrop-blur-xs">
                    <i class="fa-solid fa-clipboard-list text-xs"></i>
                    <span>Kelola Penugasan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <!-- Total Seluruh LHP -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Total Seluruh LHP
                    </p>
                    <h3 class="text-3xl font-extrabold text-slate-900 mt-2">
                        <?= esc($totalLhp) ?>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Laporan dari seluruh jajaran</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
        </div>

        <!-- LHP Draft -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        LHP Draft
                    </p>
                    <h3 class="text-3xl font-extrabold text-amber-600 mt-2">
                        <?= esc($totalDraft) ?>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Masih dalam proses pengisian</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
        </div>

        <!-- LHP Dikirim -->
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        LHP Dikirim
                    </p>
                    <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">
                        <?= esc($totalDikirim) ?>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Laporan resmi telah masuk</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Ringkasan Wilayah & Grafik Bulanan -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <!-- Ringkasan Pengawasan (Wilayah & Tahapan) -->
        <section class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 flex flex-col justify-between">
            <div>
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-red-700"></i>
                            Ringkasan Pengawasan
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Distribusi LHP berdasarkan wilayah kecamatan dan tahapan.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Berdasarkan Kecamatan -->
                    <div class="rounded-xl bg-slate-50/70 p-4 border border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot text-slate-400"></i>
                            Kecamatan
                        </h3>
                        <?php if (!empty($ringkasanWilayah)) : ?>
                            <ul class="space-y-2.5 max-h-56 overflow-y-auto pr-1">
                                <?php foreach ($ringkasanWilayah as $wilayah) : ?>
                                    <li class="flex items-center justify-between gap-3 text-xs bg-white p-2.5 rounded-lg border border-slate-200/60 shadow-2xs">
                                        <span class="text-slate-700 font-medium truncate"><?= esc($wilayah['wilayah']) ?></span>
                                        <span class="font-bold text-red-700 bg-red-50 px-2 py-0.5 rounded-md shrink-0"><?= esc($wilayah['total']) ?> LHP</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="text-xs text-slate-400 italic py-4 text-center">Belum ada data wilayah.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Berdasarkan Tahapan -->
                    <div class="rounded-xl bg-slate-50/70 p-4 border border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-3 flex items-center gap-1.5">
                            <i class="fa-solid fa-list-check text-slate-400"></i>
                            Tahapan
                        </h3>
                        <?php if (!empty($ringkasanTahapan)) : ?>
                            <ul class="space-y-2.5 max-h-56 overflow-y-auto pr-1">
                                <?php foreach ($ringkasanTahapan as $tahapan) : ?>
                                    <li class="flex items-center justify-between gap-3 text-xs bg-white p-2.5 rounded-lg border border-slate-200/60 shadow-2xs">
                                        <span class="text-slate-700 font-medium truncate"><?= esc($tahapan['tahapan']) ?></span>
                                        <span class="font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md shrink-0"><?= esc($tahapan['total']) ?> LHP</span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="text-xs text-slate-400 italic py-4 text-center">Belum ada data tahapan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Grafik Jumlah LHP per Bulan -->
        <section class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 flex flex-col justify-between">
            <div>
                <div class="mb-5">
                    <h2 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-simple text-blue-600"></i>
                        Aktivitas LHP Bulanan
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Statistik laporan yang dibuat selama 12 bulan terakhir.
                    </p>
                </div>

                <?php if ((int) $totalLhp > 0) : ?>
                    <div class="overflow-x-auto pt-2">
                        <div class="min-w-[30rem] h-56 flex items-end gap-2 sm:gap-3 border-b border-slate-200 pb-2 px-2"
                             role="img"
                             aria-label="Grafik jumlah LHP per bulan selama 12 bulan terakhir">
                            <?php foreach ($lhpBulanan as $bulan) : ?>
                                <div class="flex-1 h-full flex flex-col items-center justify-end gap-1.5 min-w-0 group">
                                    <span class="text-[11px] font-bold text-slate-600 opacity-80 group-hover:opacity-100 group-hover:text-red-700 transition-all">
                                        <?= esc($bulan['total']) ?>
                                    </span>
                                    <div class="w-full max-w-7 rounded-t-lg bg-gradient-to-t from-red-700 to-red-500 group-hover:from-red-800 group-hover:to-red-600 shadow-xs transition-all duration-200"
                                         style="height: <?= esc(max(4, $bulan['height'])) ?>%;"
                                         title="<?= esc($bulan['label'] . ': ' . $bulan['total'] . ' LHP') ?>"></div>
                                    <span class="text-[10px] font-medium text-slate-500 whitespace-nowrap group-hover:text-slate-800 transition-colors">
                                        <?= esc($bulan['label']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="h-56 flex flex-col items-center justify-center rounded-xl bg-slate-50/80 border border-dashed border-slate-200 text-center p-6">
                        <i class="fa-solid fa-chart-line text-slate-300 text-3xl mb-2"></i>
                        <p class="text-sm font-semibold text-slate-600">Belum Ada Data Grafik</p>
                        <p class="text-xs text-slate-400 mt-0.5">Data LHP bulanan akan muncul setelah laporan dibuat.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

    </div>

    <!-- Tabel LHP Terbaru Keseluruhan -->
    <section class="bg-white rounded-2xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-base sm:text-lg text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-list text-slate-500"></i>
                    LHP Terbaru (Seluruh Jajaran)
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Laporan masuk terkini dari seluruh pengawas lapangan, pimpinan, dan admin.
                </p>
            </div>

            <a href="<?= base_url('lhp') ?>" class="text-xs font-bold text-blue-700 hover:text-blue-800 flex items-center gap-1 self-start sm:self-auto">
                <span>Buka Seluruh LHP</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50/80 text-slate-600 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="text-left px-5 py-3.5">Nomor LHP</th>
                        <th class="text-left px-5 py-3.5">Pengawas</th>
                        <th class="text-left px-5 py-3.5">Diisi oleh</th>
                        <th class="text-left px-5 py-3.5">Tahapan</th>
                        <th class="text-left px-5 py-3.5">Wilayah</th>
                        <th class="text-left px-5 py-3.5">Tanggal</th>
                        <th class="text-left px-5 py-3.5">Status</th>
                        <th class="text-center px-5 py-3.5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($lhpTerbaru)) : ?>
                        <?php foreach ($lhpTerbaru as $lhp) : ?>
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-5 py-4 font-semibold text-slate-900">
                                    <?= esc($lhp['nomor_lhp'] ?: 'Belum bernomor') ?>
                                </td>
                                <td class="px-5 py-4 text-slate-700 font-medium">
                                    <?= esc($lhp['nama_pengawas'] ?? '-') ?>
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    <p class="font-medium text-slate-800"><?= esc($lhp['nama_pengisi'] ?? '-') ?></p>
                                    <span class="inline-flex text-[10px] font-semibold text-slate-500 capitalize bg-slate-100 px-1.5 py-0.5 rounded">
                                        <?= esc($lhp['role_pengisi'] ?? '-') ?>
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    <?= esc($lhp['tahapan'] ?? '-') ?>
                                </td>
                                <td class="px-5 py-4 text-slate-600">
                                    <?= esc($lhp['desa'] ?? '-') ?>,
                                    <?= esc($lhp['kecamatan'] ?? '-') ?>
                                </td>
                                <td class="px-5 py-4 text-slate-600 text-xs">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        <?= !empty($lhp['created_at'])
                                            ? esc(date('d-m-Y', strtotime($lhp['created_at'])))
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
                            <td colspan="8" class="px-5 py-12 text-center">
                                <div class="max-w-xs mx-auto text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl mx-auto mb-3">
                                        <i class="fa-regular fa-folder-open"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Belum ada LHP</p>
                                    <p class="text-xs text-slate-400 mt-1">Belum ada laporan yang dibuat dalam sistem.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</div>

<?= $this->endSection() ?>
