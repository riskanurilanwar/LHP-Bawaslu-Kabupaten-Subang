
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="mb-6">

    <h1 class="text-2xl font-bold text-slate-800">
        Dashboard Admin
    </h1>

    <p class="text-slate-500 mt-1">
        Pengelolaan pengguna dan sistem LHP.
    </p>

</div>

<!-- Statistik Pengguna -->
<div class="grid grid-cols-1 sm:grid-cols-2
            xl:grid-cols-4 gap-6 mb-8">

    <!-- Total Pengguna -->
    <div class="bg-white p-6 rounded-xl shadow-sm
                border border-slate-200">

        <p class="text-sm text-slate-500">
            Total Pengguna
        </p>

        <h3 class="text-3xl font-bold mt-3">
            <?= esc($totalPengguna) ?>
        </h3>

    </div>

    <!-- Pengawas -->
    <div class="bg-white p-6 rounded-xl shadow-sm
                border border-slate-200">

        <p class="text-sm text-slate-500">
            Total Pengawas
        </p>

        <h3 class="text-3xl font-bold mt-3 text-blue-600">
            <?= esc($totalPengawas) ?>
        </h3>

    </div>

    <!-- Pimpinan -->
    <div class="bg-white p-6 rounded-xl shadow-sm
                border border-slate-200">

        <p class="text-sm text-slate-500">
            Total Pimpinan
        </p>

        <h3 class="text-3xl font-bold mt-3 text-purple-600">
            <?= esc($totalPimpinan) ?>
        </h3>

    </div>

    <!-- Admin -->
    <div class="bg-white p-6 rounded-xl shadow-sm
                border border-slate-200">

        <p class="text-sm text-slate-500">
            Total Admin
        </p>

        <h3 class="text-3xl font-bold mt-3 text-green-600">
            <?= esc($totalAdmin) ?>
        </h3>

    </div>

</div>

<!-- Statistik LHP -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow-sm
                border border-slate-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Total Laporan Hasil Pengawasan
                </p>

                <h3 class="text-4xl font-bold mt-3">
                    <?= esc($totalLhp) ?>
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Jumlah seluruh laporan yang tersimpan
                    dalam sistem.
                </p>

            </div>

            <div class="hidden sm:flex w-16 h-16
                        rounded-2xl bg-blue-100
                        text-blue-700 items-center
                        justify-center text-3xl">

                ▤

            </div>

        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm
                border border-slate-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Total LHP Saya
                </p>

                <h3 class="text-4xl font-bold mt-3 text-indigo-700">
                    <?= esc($totalLhpSaya) ?>
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Jumlah laporan yang dibuat oleh akun Anda.
                </p>

            </div>

            <div class="hidden sm:flex w-16 h-16
                        rounded-2xl bg-indigo-100
                        text-indigo-700 items-center
                        justify-center text-3xl">

                ▤

            </div>

        </div>

    </div>

</div>

<!-- Tabel LHP Terbaru Milik Admin -->
<div class="bg-white rounded-xl shadow-sm
            border border-slate-200">

    <div class="p-6 border-b border-slate-200">

        <h3 class="font-semibold text-lg">
            LHP Terbaru Saya
        </h3>

        <p class="text-sm text-slate-500 mt-1">
            Daftar laporan terbaru yang dibuat oleh akun Anda.
        </p>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-slate-50 text-slate-600">

                <tr>

                    <th class="text-left p-4">Nomor LHP</th>
                    <th class="text-left p-4">Tahapan</th>
                    <th class="text-left p-4">Waktu Pengawasan</th>
                    <th class="text-left p-4">Status</th>
                    <th class="text-left p-4">Aksi</th>

                </tr>

            </thead>

            <tbody>

                <?php if (!empty($lhpTerbaruSaya)) : ?>

                    <?php foreach ($lhpTerbaruSaya as $lhp) : ?>

                        <tr class="border-b border-slate-100 hover:bg-slate-50">

                            <td class="p-4 font-medium">
                                <?= esc($lhp['nomor_lhp'] ?? 'Belum memiliki nomor') ?>
                            </td>

                            <td class="p-4">
                                <?= esc($lhp['tahapan'] ?? '-') ?>
                            </td>

                            <td class="p-4">
                                <?= !empty($lhp['waktu_pengawasan'])
                                    ? esc(date('d-m-Y H:i', strtotime($lhp['waktu_pengawasan'])))
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
                                   class="font-medium text-blue-700 hover:text-blue-900">
                                    Detail
                                </a>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">
                            Anda belum membuat LHP.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<?= $this->endSection() ?>
