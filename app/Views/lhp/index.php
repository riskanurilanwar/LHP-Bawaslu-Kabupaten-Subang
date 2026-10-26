<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Daftar LHP
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Data Laporan Hasil Pengawasan yang tersimpan dalam sistem.
            </p>
        </div>

        <a href="<?= base_url('lhp/tambah') ?>"
           class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">
            + Buat LHP
        </a>
    </div>

    <!-- Pencarian -->
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <form action="<?= base_url('lhp') ?>" method="get"
              class="flex flex-col gap-3 sm:flex-row">

            <input
                type="text"
                name="keyword"
                value="<?= esc($_GET['keyword'] ?? '') ?>"
                placeholder="Cari nomor LHP, wilayah, atau nama pengawas..."
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100"
            >

            <button
                type="submit"
                class="rounded-lg bg-gray-800 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-700">
                Cari
            </button>

            <a href="<?= base_url('lhp') ?>"
               class="rounded-lg border border-gray-300 px-5 py-2.5 text-center text-sm font-medium text-gray-600 hover:bg-gray-50">
                Reset
            </a>
        </form>
    </div>

    <!-- Tabel LHP -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            No.
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Nomor LHP
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Tanggal
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Wilayah
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Pengawas
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    <?php if (!empty($lhp) && count($lhp) > 0): ?>

                        <?php foreach ($lhp as $index => $item): ?>
                            <tr class="hover:bg-gray-50">

                                <td class="px-5 py-4 text-gray-500">
                                    <?= $pager->getCurrentPage() * $pager->getPerPage()
                                        - $pager->getPerPage()
                                        + $index + 1 ?>
                                </td>

                                <td class="px-5 py-4 font-medium text-gray-800">
                                    <?= esc($item['nomor_lhp'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    <?= !empty($item['waktu_pengawasan'])
                                        ? date('d-m-Y', strtotime($item['waktu_pengawasan']))
                                        : '-' ?>
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    <?= esc($item['desa'] ?? '-') ?>,
                                    <?= esc($item['kecamatan'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    <?= esc($item['nama_pengawas'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">

                                        <a href="<?= base_url('lhp/detail/' . $item['id']) ?>"
                                           class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">
                                            Detail
                                        </a>

                                        <a href="<?= base_url('lhp/cetak/' . $item['id']) ?>"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="rounded-md bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 hover:bg-green-100">
                                            Cetak
                                        </a>

                                        <?php if (session()->get('role') === 'pengawas') : ?>
                                            <a href="<?= base_url('lhp/edit/' . $item['id']) ?>"
                                               class="rounded-md bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 hover:bg-amber-100">
                                                Edit
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6"
                                class="px-5 py-10 text-center text-gray-500">
                                Belum ada data LHP yang tersedia.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="border-t border-gray-200 px-5 py-4">
            <?= $pager->links('default', 'default_full') ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>