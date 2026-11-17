
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="mb-6">

    <h1 class="text-2xl font-bold text-slate-800">
        Dashboard Pimpinan
    </h1>

    <p class="text-slate-500 mt-1">
        Ringkasan Laporan Hasil Pengawasan.
    </p>

</div>

<!-- Statistik -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow-sm
                border border-slate-200">

        <p class="text-sm text-slate-500">
            Total Seluruh LHP
        </p>

        <h3 class="text-3xl font-bold mt-3">
            <?= esc($totalLhp) ?>
        </h3>

    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm
                border border-slate-200">

        <p class="text-sm text-slate-500">
            LHP Draft
        </p>

        <h3 class="text-3xl font-bold mt-3 text-yellow-600">
            <?= esc($totalDraft) ?>
        </h3>

    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm
                border border-slate-200">

        <p class="text-sm text-slate-500">
            LHP Dikirim
        </p>

        <h3 class="text-3xl font-bold mt-3 text-green-600">
            <?= esc($totalDikirim) ?>
        </h3>

    </div>

</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

    <section class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="mb-5">
            <h2 class="text-lg font-semibold text-slate-800">
                Ringkasan Pengawasan
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Jumlah LHP berdasarkan wilayah dan tahapan pengawasan.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-semibold text-slate-700 mb-3">
                    Berdasarkan Kecamatan
                </h3>
                <?php if (!empty($ringkasanWilayah)) : ?>
                    <ul class="space-y-3">
                        <?php foreach ($ringkasanWilayah as $wilayah) : ?>
                            <li class="flex items-center justify-between gap-3 text-sm">
                                <span class="text-slate-600"><?= esc($wilayah['wilayah']) ?></span>
                                <span class="font-semibold text-slate-800"><?= esc($wilayah['total']) ?> LHP</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-sm text-slate-400">Belum ada data wilayah.</p>
                <?php endif; ?>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-700 mb-3">
                    Berdasarkan Tahapan
                </h3>
                <?php if (!empty($ringkasanTahapan)) : ?>
                    <ul class="space-y-3">
                        <?php foreach ($ringkasanTahapan as $tahapan) : ?>
                            <li class="flex items-center justify-between gap-3 text-sm">
                                <span class="text-slate-600"><?= esc($tahapan['tahapan']) ?></span>
                                <span class="font-semibold text-slate-800"><?= esc($tahapan['total']) ?> LHP</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-sm text-slate-400">Belum ada data tahapan.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="mb-5">
            <h2 class="text-lg font-semibold text-slate-800">
                Jumlah LHP per Bulan
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                LHP dibuat dalam 12 bulan terakhir.
            </p>
        </div>

        <?php if ((int) $totalLhp > 0) : ?>
            <div class="overflow-x-auto">
                <div class="min-w-[32rem] h-52 flex items-end gap-2 sm:gap-3 border-b border-slate-200 pb-2"
                     role="img"
                     aria-label="Grafik jumlah LHP per bulan selama 12 bulan terakhir">
                    <?php foreach ($lhpBulanan as $bulan) : ?>
                        <div class="flex-1 h-full flex flex-col items-center justify-end gap-2 min-w-0">
                            <span class="text-xs text-slate-500"><?= esc($bulan['total']) ?></span>
                            <div class="w-full max-w-8 rounded-t-md bg-blue-600 hover:bg-blue-700 transition-colors"
                                 style="height: <?= esc(max(2, $bulan['height'])) ?>%;"
                                 title="<?= esc($bulan['label'] . ': ' . $bulan['total'] . ' LHP') ?>"></div>
                            <span class="text-[10px] sm:text-xs text-slate-500 whitespace-nowrap">
                                <?= esc($bulan['label']) ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
        <?php else : ?>
            <div class="h-52 flex items-center justify-center rounded-lg bg-slate-50 text-sm text-slate-400">
                Belum ada data LHP untuk ditampilkan.
            </div>
        <?php endif; ?>
    </section>

</div>

<section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-200">
        <h2 class="text-lg font-semibold text-slate-800">LHP Terbaru</h2>
        <p class="text-sm text-slate-500 mt-1">
            Laporan terbaru dari seluruh pengawas, pimpinan, dan admin.
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left p-4">Nomor LHP</th>
                    <th class="text-left p-4">Pengawas</th>
                    <th class="text-left p-4">Diisi oleh</th>
                    <th class="text-left p-4">Tahapan</th>
                    <th class="text-left p-4">Wilayah</th>
                    <th class="text-left p-4">Tanggal dibuat</th>
                    <th class="text-left p-4">Status</th>
                    <th class="text-left p-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lhpTerbaru)) : ?>
                    <?php foreach ($lhpTerbaru as $lhp) : ?>
                        <tr class="border-b border-slate-100 hover:bg-slate-50">
                            <td class="p-4 font-medium">
                                <?= esc($lhp['nomor_lhp'] ?: 'Belum bernomor') ?>
                            </td>
                            <td class="p-4"><?= esc($lhp['nama_pengawas'] ?? '-') ?></td>
                            <td class="p-4">
                                <?= esc($lhp['nama_pengisi'] ?? '-') ?>
                                <span class="block text-xs text-slate-500 capitalize">
                                    <?= esc($lhp['role_pengisi'] ?? '-') ?>
                                </span>
                            </td>
                            <td class="p-4"><?= esc($lhp['tahapan'] ?? '-') ?></td>
                            <td class="p-4">
                                <?= esc($lhp['desa'] ?? '-') ?>,
                                <?= esc($lhp['kecamatan'] ?? '-') ?>
                            </td>
                            <td class="p-4">
                                <?= !empty($lhp['created_at'])
                                    ? esc(date('d-m-Y', strtotime($lhp['created_at'])))
                                    : '-' ?>
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs
                                    <?= strtolower($lhp['status'] ?? '') === 'dikirim'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' ?>">
                                    <?= esc($lhp['status'] ?? '-') ?>
                                </span>
                            </td>
                            <td class="p-4">
                                <a href="<?= base_url('lhp/detail/' . $lhp['id']) ?>"
                                   class="text-blue-700 hover:text-blue-900 font-medium">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400">
                            Belum ada LHP yang dibuat.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?= $this->endSection() ?>
