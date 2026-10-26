<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Rekapitulasi LHP
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Ringkasan laporan hasil pengawasan berdasarkan periode.
        </p>
        <a
            href="<?= base_url('rekapitulasi-lhp/cetak?' . http_build_query([
                'bulan' => $bulan,
                'tahun' => $tahun,
            ])) ?>"
            target="_blank"
            class="inline-flex items-center rounded-lg bg-green-600
                px-4 py-2 text-white hover:bg-green-700"
        >
            Cetak Rekapitulasi
        </a>
    </div>

    <!-- Filter -->
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

        <form
            action="<?= base_url('rekapitulasi-lhp') ?>"
            method="get"
            class="grid grid-cols-1 gap-4 md:grid-cols-3"
        >

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Bulan
                </label>

                <select
                    name="bulan"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
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
                            <?= (string) $bulan === (string) $nomor
                                ? 'selected' : '' ?>
                        >
                            <?= esc($nama) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700">
                    Tahun
                </label>

                <select
                    name="tahun"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
                >
                    <option value="">Semua Tahun</option>

                    <?php for ($year = date('Y'); $year >= 2024; $year--): ?>
                        <option
                            value="<?= $year ?>"
                            <?= (string) $tahun === (string) $year
                                ? 'selected' : '' ?>
                        >
                            <?= $year ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white
                           hover:bg-blue-700"
                >
                    Filter
                </button>

                <a
                    href="<?= base_url('rekapitulasi-lhp') ?>"
                    class="rounded-lg border border-gray-300 px-4 py-2
                           text-gray-700 hover:bg-gray-100"
                >
                    Reset
                </a>
            </div>

        </form>
    </div>

    <!-- Ringkasan -->
    <div class="grid grid-cols-1 gap-4">

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total LHP</p>
            <h2 class="mt-2 text-3xl font-bold text-gray-800">
                <?= $totalLhp ?>
            </h2>
        </div>

    </div>

    <!-- Tabel Rekapitulasi -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="border-b border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800">
                Data Rekapitulasi
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-5 py-3">No.</th>
                        <th class="px-5 py-3">Nomor LHP</th>
                        <th class="px-5 py-3">Tanggal</th>
                        <th class="px-5 py-3">Wilayah</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    <?php if (empty($lhp)): ?>

                        <tr>
                            <td
                                colspan="5"
                                class="px-5 py-8 text-center text-gray-500"
                            >
                                Tidak ada data LHP untuk filter yang dipilih.
                            </td>
                        </tr>

                    <?php else: ?>

                        <?php foreach ($lhp as $index => $item): ?>

                            <tr class="hover:bg-gray-50">

                                <td class="px-5 py-3">
                                    <?= $index + 1 ?>
                                </td>

                                <td class="px-5 py-3 font-medium text-gray-800">
                                    <?= esc($item['nomor_lhp'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-3">
                                    <?= !empty($item['waktu_pengawasan'])
                                        ? esc(date('d-m-Y H:i', strtotime($item['waktu_pengawasan'])))
                                        : '-' ?>
                                </td>

                                <td class="px-5 py-3">
                                    <?= esc($item['desa'] ?? '-') ?>
                                </td>

                                <td class="px-5 py-3">
                                    <a
                                        href="<?= base_url('lhp/detail/' . $item['id']) ?>"
                                        class="font-medium text-blue-600 hover:underline"
                                    >
                                        Detail
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