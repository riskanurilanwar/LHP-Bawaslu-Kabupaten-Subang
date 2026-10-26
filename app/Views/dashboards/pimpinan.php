
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="mb-6">

    <h1 class="text-2xl font-bold text-slate-800">
        Dashboard Pimpinan
    </h1>

    <p class="text-slate-500 mt-1">
        Monitoring seluruh Laporan Hasil Pengawasan.
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

<!-- Monitoring LHP Terbaru -->
<div class="bg-white rounded-xl shadow-sm
            border border-slate-200">

    <div class="p-6 border-b border-slate-200">

        <h3 class="font-semibold text-lg">
            LHP Terbaru
        </h3>

        <p class="text-sm text-slate-500 mt-1">
            Laporan terbaru dari seluruh Pengawas.
        </p>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-slate-50 text-slate-600">

                <tr>

                    <th class="text-left p-4">
                        Nomor LHP
                    </th>

                    <th class="text-left p-4">
                        Pengawas
                    </th>

                    <th class="text-left p-4">
                        Tahapan
                    </th>

                    <th class="text-left p-4">
                        Waktu Pengawasan
                    </th>

                    <th class="text-left p-4">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php if (!empty($lhpTerbaru)) : ?>

                    <?php foreach ($lhpTerbaru as $lhp) : ?>

                        <tr class="border-b border-slate-100
                                   hover:bg-slate-50">

                            <td class="p-4 font-medium">

                                <?= esc(
                                    $lhp['nomor_lhp']
                                    ?? 'Belum memiliki nomor'
                                ) ?>

                            </td>

                            <td class="p-4">

                                <?= esc(
                                    $lhp['nama_pengawas'] ?? '-'
                                ) ?>

                            </td>

                            <td class="p-4">

                                <?= esc($lhp['tahapan'] ?? '-') ?>

                            </td>

                            <td class="p-4">

                                <?= esc(
                                    $lhp['waktu_pengawasan'] ?? '-'
                                ) ?>

                            </td>

                            <td class="p-4">

                                <span class="px-3 py-1 rounded-full
                                             text-xs bg-blue-100
                                             text-blue-700">

                                    <?= esc($lhp['status'] ?? '-') ?>

                                </span>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>

                        <td
                            colspan="5"
                            class="p-8 text-center text-slate-400"
                        >

                            Belum ada laporan yang masuk.

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?>
