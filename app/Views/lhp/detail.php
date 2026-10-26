<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
    $sections = [
        'Identitas Laporan' => [
            'nomor_lhp' => 'Nomor LHP',
            'status' => 'Status',
            'tahapan' => 'Tahapan',
            'nama_pengawas' => 'Nama Pengawas',
            'jabatan_pengawas' => 'Jabatan',
            'nomor_surat_tugas' => 'Nomor Surat Tugas',
            'tanggal_surat_tugas' => 'Tanggal Surat Tugas',
            'alamat_pengawas' => 'Alamat Pengawas',
        ],
        'Kegiatan Pengawasan' => [
            'bentuk_pengawasan' => 'Bentuk Pengawasan',
            'tujuan_pengawasan' => 'Tujuan Pengawasan',
            'sasaran_pengawasan' => 'Sasaran Pengawasan',
            'waktu_pengawasan' => 'Waktu Pengawasan',
            'tempat_pengawasan' => 'Tempat Pengawasan',
            'kecamatan' => 'Kecamatan',
            'desa' => 'Desa',
            'tps' => 'TPS',
            'uraian_hasil' => 'Uraian Hasil',
        ],
        'Dugaan Pelanggaran' => [
            'ada_dugaan_pelanggaran' => 'Ada Dugaan Pelanggaran',
            'peristiwa_pelanggaran' => 'Peristiwa Pelanggaran',
            'tempat_pelanggaran' => 'Tempat Pelanggaran',
            'waktu_pelanggaran' => 'Waktu Pelanggaran',
            'pelaku_pelanggaran' => 'Pelaku Pelanggaran',
            'alamat_pelaku' => 'Alamat Pelaku',
            'saksi' => 'Saksi',
            'barang_bukti' => 'Barang Bukti',
            'uraian_pelanggaran' => 'Uraian Pelanggaran',
            'fakta_pelanggaran' => 'Fakta Pelanggaran',
            'analisa_pelanggaran' => 'Analisa Pelanggaran',
        ],
    ];

    $sections['Potensi Sengketa'] = [
        'ada_potensi_sengketa' => 'Ada Potensi Sengketa',
    ];

    if ((int) ($lhp['ada_potensi_sengketa'] ?? 0) === 1) {
        $sections['Potensi Sengketa'] += [
            'peserta_sengketa' => 'Peserta Pemilu',
            'tempat_sengketa' => 'Tempat Kejadian',
            'waktu_sengketa' => 'Waktu Kejadian',
            'bentuk_objek_sengketa' => 'Bentuk Objek Sengketa',
            'objek_sengketa' => 'Identitas Objek Sengketa',
            'tanggal_objek_dikeluarkan' => 'Hari/Tanggal Objek Dikeluarkan',
            'kerugian_langsung' => 'Kerugian Langsung',
            'uraian_sengketa' => 'Uraian Singkat Potensi Sengketa',
        ];
    }

    $formatValue = static function ($value): string {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_string($value) && str_starts_with($value, '[')) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $value = implode("\n", array_filter(array_map(
                    static fn ($witness): string => implode(' - ', array_filter([
                        $witness['nama'] ?? '',
                        $witness['alamat'] ?? '',
                    ])),
                    $decoded
                )));
            }
        }

        return nl2br(esc((string) $value));
    };
?>

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Detail LHP</h1>
            <p class="mt-1 text-sm text-slate-500">
                <?= esc($lhp['nomor_lhp'] ?: 'Laporan Hasil Pengawasan') ?>
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="<?= base_url('lhp/cetak/' . $lhp['id']) ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center justify-center rounded-lg bg-blue-700 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-800">
                Cetak LHP
            </a>
            <a href="<?= base_url('lhp') ?>"
               class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <?php foreach ($sections as $title => $fields): ?>
        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-slate-800">
                <?= esc($title) ?>
            </h2>

            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <?php foreach ($fields as $field => $label): ?>
                    <div class="border-b border-slate-100 pb-3">
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">
                            <?= esc($label) ?>
                        </dt>
                        <dd class="mt-1 whitespace-pre-line text-sm text-slate-800">
                            <?php if (in_array($field, ['ada_dugaan_pelanggaran', 'ada_potensi_sengketa'], true)): ?>
                                <?= (int) ($lhp[$field] ?? 0) === 1 ? 'Ya' : 'Tidak' ?>
                            <?php else: ?>
                                <?= $formatValue($lhp[$field] ?? null) ?>
                            <?php endif; ?>
                        </dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </section>
    <?php endforeach; ?>

    <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold text-slate-800">Lampiran Foto Bukti</h2>

        <?php if (!empty($lampiran)): ?>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($lampiran as $file): ?>
                    <?php $imageUrl = base_url('lhp/lampiran/' . $file['id']); ?>
                    <figure class="overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
                        <a href="<?= esc($imageUrl) ?>" target="_blank" rel="noopener noreferrer">
                            <img
                                src="<?= esc($imageUrl) ?>"
                                alt="<?= esc($file['nama_asli'] ?? 'Foto bukti pengawasan') ?>"
                                loading="lazy"
                                class="h-56 w-full object-contain"
                            >
                        </a>
                        <figcaption class="border-t border-slate-200 bg-white px-3 py-2">
                            <span class="block truncate text-sm font-medium text-slate-800">
                                <?= esc($file['nama_asli'] ?? $file['nama_file']) ?>
                            </span>
                            <span class="text-xs text-slate-500">
                                <?= esc($file['tipe_file'] ?? '') ?>
                                <?php if (isset($file['ukuran_file'])): ?>
                                    · <?= number_format((int) $file['ukuran_file'] / 1024, 1) ?> KB
                                <?php endif; ?>
                            </span>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-sm text-slate-500">Tidak ada lampiran foto.</p>
        <?php endif; ?>
    </section>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= esc(session()->getFlashdata('success'), 'js') ?>',
            confirmButtonColor: '#2563eb'
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= esc(session()->getFlashdata('error'), 'js') ?>',
            confirmButtonColor: '#2563eb'
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>
