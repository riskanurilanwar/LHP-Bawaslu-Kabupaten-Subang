<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Monitoring LHP
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Pantau laporan hasil pengawasan yang masuk.
        </p>
    </div>

    <!-- Filter -->
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">

        <form action="<?= base_url('monitoring-lhp') ?>"
              method="get"
              class="grid grid-cols-1 gap-3 md:grid-cols-2">

            <input
                type="text"
                name="keyword"
                value="<?= esc($_GET['keyword'] ?? '') ?>"
                placeholder="Cari nomor, pengawas, atau wilayah..."
                class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"
            >

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                    Filter
                </button>

                <a href="<?= base_url('monitoring-lhp') ?>"
                   class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50">
                    Reset
                </a>
            </div>

        </form>
    </div>

    <!-- Tabel -->
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
                            Pengawas
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Wilayah
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    <?php if (!empty($lhp)): ?>

                        <?php foreach ($lhp as $index => $item): ?>

                            <tr class="hover:bg-gray-50">

                                <td class="px-5 py-4 text-gray-500">
                                    <?= $index + 1 ?>
                                </td>

                                <td class="px-5 py-4 font-medium text-gray-800">
                                    <?= esc($item['nomor_lhp'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    <?= esc($item['nama_pengawas'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    <?= esc($item['desa'] ?? '-') ?>,
                                    <?= esc($item['kecamatan'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-4">
                                    <a href="<?= base_url('lhp/detail/' . $item['id']) ?>"
                                       class="rounded-md bg-blue-50 px-3 py-1.5 text-xs font-medium text-blue-700 hover:bg-blue-100">
                                        Detail
                                    </a>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5"
                                class="px-5 py-10 text-center text-gray-500">
                                Tidak ada data LHP yang ditemukan.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

        <div class="border-t border-gray-200 px-5 py-4">
            <?= $pager->links('default', 'default_full') ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>