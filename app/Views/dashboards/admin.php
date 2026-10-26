
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

<?= $this->endSection() ?>
