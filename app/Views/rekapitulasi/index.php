<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Header Halaman -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                <p class="text-xs font-bold uppercase tracking-wider text-red-700">Laporan Berkala</p>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
                <i class="fa-solid fa-chart-column text-red-700"></i>
                Rekapitulasi LHP
            </h1>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Ringkasan komprehensif laporan hasil pengawasan berdasarkan filter periode bulan dan tahun.
            </p>
        </div>

        <a
            href="<?= base_url('rekapitulasi-lhp/cetak?' . http_build_query([
                'bulan' => $bulan,
                'tahun' => $tahun,
            ])) ?>"
            target="_blank"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-emerald-950/20 hover:from-emerald-700 hover:to-emerald-800 transition-all shrink-0"
        >
            <i class="fa-solid fa-print text-xs"></i>
            <span>Cetak Rekapitulasi</span>
        </a>
    </div>

    <!-- Filter Periode -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs">
        <form
            action="<?= base_url('rekapitulasi-lhp') ?>"
            method="get"
            class="grid grid-cols-1 gap-4 sm:grid-cols-3"
        >
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Bulan Pengawasan
                </label>
                <select
                    name="bulan"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-3.5 py-2.5 text-sm text-slate-700 outline-none focus:bg-white focus:border-red-500 transition-all"
                >
                    <option value="">Semua Bulan</option>
                    <?php
                    $namaBulan = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ];
                    ?>
                    <?php foreach ($namaBulan as $nomor => $nama): ?>
                        <option
                            value="<?= $nomor ?>"
                            <?= (string) $bulan === (string) $nomor ? 'selected' : '' ?>
                        >
                            <?= esc($nama) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Tahun Pengawasan
                </label>
                <select
                    name="tahun"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-3.5 py-2.5 text-sm text-slate-700 outline-none focus:bg-white focus:border-red-500 transition-all"
                >
                    <option value="">Semua Tahun</option>
                    <?php for ($year = date('Y'); $year >= 2024; $year--): ?>
                        <option
                            value="<?= $year ?>"
                            <?= (string) $tahun === (string) $year ? 'selected' : '' ?>
                        >
                            <?= $year ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-slate-900 transition-colors"
                >
                    <i class="fa-solid fa-filter text-xs"></i>
                    <span>Terapkan Filter</span>
                </button>

                <a
                    href="<?= base_url('rekapitulasi-lhp') ?>"
                    class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors"
                    title="Reset Filter"
                >
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Reset</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Ringkasan Statistik Periode -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl shadow-xs border border-slate-200/80">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Total LHP Periode Ini
                    </p>
                    <h2 class="text-3xl font-extrabold text-slate-900 mt-2">
                        <?= $totalLhp ?>
                    </h2>
                    <p class="text-[11px] text-slate-400 mt-1">Laporan yang memenuhi kriteria filter</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-xl shadow-xs">
                    <i class="fa-solid fa-file-shield"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rekapitulasi -->
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs">
        <div class="border-b border-slate-100 p-5 flex items-center justify-between">
            <h2 class="font-bold text-base text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-table-list text-slate-400"></i>
                Rincian Data Rekapitulasi
            </h2>
            <span class="text-xs text-slate-500 font-medium">
                <?= (int) $totalLhp ?> Data Terdaftar
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/90 text-slate-600 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5 text-center w-14">No.</th>
                        <th class="px-5 py-3.5">Nomor LHP</th>
                        <th class="px-5 py-3.5">Tanggal & Waktu</th>
                        <th class="px-5 py-3.5">Wilayah Desa</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($lhp)): ?>
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center">
                                <div class="max-w-xs mx-auto text-center">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                        <i class="fa-regular fa-folder-open"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Tidak Ada Data LHP</p>
                                    <p class="text-xs text-slate-400 mt-1">Tidak ada data laporan untuk filter periode yang dipilih.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($lhp as $index => $item): ?>
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="px-5 py-4 text-center text-xs font-medium text-slate-400">
                                    <?= $index + 1 ?>
                                </td>

                                <td class="px-5 py-4 font-bold text-slate-900">
                                    <?= esc($item['nomor_lhp'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-4 text-xs text-slate-600">
                                    <div class="flex items-center gap-1.5 font-medium">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        <?= !empty($item['waktu_pengawasan'])
                                            ? esc(date('d-m-Y H:i', strtotime($item['waktu_pengawasan'])))
                                            : '-' ?>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-xs text-slate-700 font-medium">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-slate-400"></i>
                                        <span><?= esc($item['desa'] ?? '-') ?></span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <a
                                        href="<?= base_url('lhp/detail/' . $item['id']) ?>"
                                        class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100 transition-colors"
                                    >
                                        <i class="fa-regular fa-eye text-xs"></i>
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>