<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Header Halaman -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                <p class="text-xs font-bold uppercase tracking-wider text-red-700">Formulir Model A.1</p>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
                <i class="fa-solid fa-file-shield text-red-700"></i>
                Daftar Laporan Hasil Pengawasan
            </h1>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Pusat data dokumen dan arsip Laporan Hasil Pengawasan (LHP) Bawaslu Kabupaten Subang.
            </p>
        </div>

        <a href="<?= base_url('lhp/tambah') ?>"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-red-900/30 hover:from-red-700 hover:to-red-800 transition-all duration-150 shrink-0">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Buat LHP Baru</span>
        </a>
    </div>

    <!-- Pencarian dan Filter -->
    <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-xs">
        <form action="<?= base_url('lhp') ?>" method="get" class="space-y-3.5">

            <!-- Input Pencarian Bebas -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </div>
                <input
                    type="text"
                    name="keyword"
                    value="<?= esc($keyword) ?>"
                    placeholder="Cari nomor LHP, tahapan, wilayah kecamatan/desa, nomor surat tugas, atau nama pengawas..."
                    class="w-full rounded-xl border border-slate-300 bg-slate-50/70 pl-10 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100 transition-all duration-150"
                >
            </div>

            <!-- Filter Grid -->
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div class="relative">
                    <select name="status"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-3.5 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-red-500 focus:outline-none transition-all">
                        <option value="">Semua status</option>
                        <option value="draft" <?= $statusFilter === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="dikirim" <?= $statusFilter === 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
                    </select>
                </div>

                <div class="relative">
                    <select name="tahapan"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-3.5 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-red-500 focus:outline-none transition-all">
                        <option value="">Semua tahapan</option>
                        <?php foreach ($tahapanOptions as $option) : ?>
                            <option value="<?= esc($option) ?>" <?= $tahapanFilter === $option ? 'selected' : '' ?>>
                                <?= esc($option) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="relative">
                    <select name="kecamatan"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-3.5 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-red-500 focus:outline-none transition-all">
                        <option value="">Semua kecamatan</option>
                        <?php foreach ($kecamatanOptions as $option) : ?>
                            <option value="<?= esc($option) ?>" <?= $kecamatanFilter === $option ? 'selected' : '' ?>>
                                <?= esc($option) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-slate-900 transition-colors">
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filter</span>
                    </button>
                    <a href="<?= base_url('lhp') ?>"
                       class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors"
                       title="Reset filter pencarian">
                        <i class="fa-solid fa-rotate-left text-xs"></i>
                        <span>Reset</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data LHP -->
    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xs">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-sm">

                <thead class="bg-slate-50/90">
                    <tr>
                        <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-500 w-14">
                            No.
                        </th>

                        <th class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">
                            Nomor LHP & Tahapan
                        </th>

                        <th class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">
                            Waktu Pengawasan
                        </th>

                        <th class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">
                            Wilayah Lokasi
                        </th>

                        <th class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-600">
                            Pelaksana / Pengawas
                        </th>

                        <th class="px-5 py-3.5 text-center text-xs font-bold uppercase tracking-wider text-slate-600">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    <?php if (!empty($lhp) && count($lhp) > 0): ?>

                        <?php foreach ($lhp as $index => $item): ?>
                            <tr class="hover:bg-slate-50/70 transition-colors">

                                <td class="px-5 py-4 text-center text-xs font-medium text-slate-400">
                                    <?= $pager->getCurrentPage() * $pager->getPerPage()
                                        - $pager->getPerPage()
                                        + $index + 1 ?>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-bold text-slate-900">
                                        <?= esc($item['nomor_lhp'] ?? '-') ?>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5">
                                        <?= esc($item['tahapan'] ?? '-') ?>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-xs text-slate-600">
                                    <div class="flex items-center gap-1.5 font-medium">
                                        <i class="fa-regular fa-calendar text-slate-400"></i>
                                        <?= !empty($item['waktu_pengawasan'])
                                            ? date('d-m-Y', strtotime($item['waktu_pengawasan']))
                                            : '-' ?>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-xs text-slate-600">
                                    <div class="flex items-center gap-1.5 font-medium">
                                        <i class="fa-solid fa-location-dot text-slate-400"></i>
                                        <span><?= esc($item['desa'] ?? '-') ?>, Kec. <?= esc($item['kecamatan'] ?? '-') ?></span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-xs text-slate-700">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-[10px] shrink-0">
                                            <?= strtoupper(substr($item['nama_pengawas'] ?? 'P', 0, 1)) ?>
                                        </div>
                                        <span class="font-semibold text-slate-800">
                                            <?= esc($item['nama_pengawas'] ?? '-') ?>
                                        </span>
                                    </div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <div class="inline-flex items-center gap-1.5 justify-center">

                                        <a href="<?= base_url('lhp/detail/' . $item['id'])
                                            . ($returnQuery !== '' ? '?' . esc($returnQuery) : '') ?>"
                                           class="inline-flex items-center gap-1 rounded-lg bg-blue-50 px-2.5 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100 transition-colors">
                                            <i class="fa-regular fa-eye text-xs"></i>
                                            <span>Detail</span>
                                        </a>

                                        <a href="<?= base_url('lhp/cetak/' . $item['id']) ?>"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 px-2.5 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition-colors">
                                            <i class="fa-solid fa-print text-xs"></i>
                                            <span>Cetak</span>
                                        </a>

                                        <?php if (session()->get('role') === 'pengawas') : ?>
                                            <a href="<?= base_url('lhp/edit/' . $item['id']) ?>"
                                               class="inline-flex items-center gap-1 rounded-lg bg-amber-50 px-2.5 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-100 transition-colors">
                                                <i class="fa-regular fa-pen-to-square text-xs"></i>
                                                <span>Edit</span>
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="max-w-xs mx-auto text-center">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                                        <i class="fa-regular fa-folder-open"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700">Tidak Ada Data LHP</p>
                                    <p class="text-xs text-slate-400 mt-1">Belum ada laporan yang sesuai dengan filter atau pencarian Anda.</p>
                                    <a href="<?= base_url('lhp') ?>" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-red-700 hover:text-red-800">
                                        <i class="fa-solid fa-rotate-left text-[10px]"></i>
                                        <span>Reset Pencarian</span>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="border-t border-slate-100 bg-slate-50/50 px-5 py-3.5">
            <?= $pager->only(['keyword', 'status', 'tahapan', 'kecamatan'])
                ->links('default', 'default_full') ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>