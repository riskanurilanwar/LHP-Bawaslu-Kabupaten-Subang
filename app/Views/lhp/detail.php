<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
    $sections = [
        'Identitas Laporan' => [
            'icon' => 'fa-id-card',
            'fields' => [
                'nomor_lhp' => 'Nomor LHP',
                'status' => 'Status',
                'tahapan' => 'Tahapan',
                'nama_pengawas' => 'Nama Pengawas',
                'jabatan_pengawas' => 'Jabatan',
                'nomor_surat_tugas' => 'Nomor Surat Tugas',
                'tanggal_surat_tugas' => 'Tanggal Surat Tugas',
                'alamat_pengawas' => 'Alamat Pengawas',
            ]
        ],
        'Kegiatan Pengawasan' => [
            'icon' => 'fa-magnifying-glass-chart',
            'fields' => [
                'bentuk_pengawasan' => 'Bentuk Pengawasan',
                'tujuan_pengawasan' => 'Tujuan Pengawasan',
                'sasaran_pengawasan' => 'Sasaran Pengawasan',
                'waktu_pengawasan' => 'Waktu Pengawasan',
                'tempat_pengawasan' => 'Tempat Pengawasan',
                'kecamatan' => 'Kecamatan',
                'desa' => 'Desa',
                'tps' => 'TPS',
                'uraian_hasil' => 'Uraian Hasil',
            ]
        ],
        'Dugaan Pelanggaran' => [
            'icon' => 'fa-triangle-exclamation',
            'fields' => [
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
            ]
        ],
    ];

    $sengketaFields = [
        'ada_potensi_sengketa' => 'Ada Potensi Sengketa',
    ];

    if ((int) ($lhp['ada_potensi_sengketa'] ?? 0) === 1) {
        $sengketaFields += [
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

    $sections['Potensi Sengketa'] = [
        'icon' => 'fa-scale-balanced',
        'fields' => $sengketaFields
    ];

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

    $isDikirim = strtolower($lhp['status'] ?? '') === 'dikirim';
?>

<div class="space-y-6">

    <!-- Header Action Bar -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="<?= base_url('lhp') . ($returnQuery !== '' ? '?' . esc($returnQuery) : '') ?>"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-red-700 transition-colors">
                    <i class="fa-solid fa-arrow-left text-[11px]"></i>
                    <span>Kembali ke Daftar LHP</span>
                </a>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-file-lines text-red-700"></i>
                Detail Laporan Hasil Pengawasan
            </h1>
            <p class="mt-0.5 text-xs sm:text-sm text-slate-500">
                <?= esc($lhp['nomor_lhp'] ?: 'Dokumen Formulir Model A.1 LHP') ?>
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <?php if (session()->get('role') === 'pengawas'): ?>
                <a href="<?= base_url('lhp/edit/' . $lhp['id']) ?>"
                   class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-amber-300 bg-amber-50 px-4 py-2.5 text-xs sm:text-sm font-semibold text-amber-800 hover:bg-amber-100 transition-colors shadow-xs">
                    <i class="fa-regular fa-pen-to-square"></i>
                    <span>Edit LHP</span>
                </a>
            <?php endif; ?>

            <a href="<?= base_url('lhp/cetak/' . $lhp['id']) ?>"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-2.5 text-xs sm:text-sm font-bold text-white hover:from-red-700 hover:to-red-800 transition-all shadow-md shadow-red-950/20">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Dokumen</span>
            </a>
        </div>
    </div>

    <!-- Ringkasan Cepat / Status Hero Banner -->
    <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-700 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-bold text-base sm:text-lg text-slate-900"><?= esc($lhp['nomor_lhp'] ?: 'Belum Memiliki Nomor') ?></span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold
                            <?= $isDikirim
                                ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20'
                                : 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20' ?>">
                            <span class="w-1.5 h-1.5 rounded-full <?= $isDikirim ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
                            <?= esc($lhp['status'] ?? '-') ?>
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        Tahapan: <span class="font-medium text-slate-700"><?= esc($lhp['tahapan'] ?? '-') ?></span> &bull;
                        Pengawas: <span class="font-medium text-slate-700"><?= esc($lhp['nama_pengawas'] ?? '-') ?></span>
                    </p>
                </div>
            </div>

            <div class="text-xs text-slate-500 flex items-center gap-1.5 bg-slate-50 px-3.5 py-2 rounded-xl border border-slate-200/60 self-start sm:self-auto">
                <i class="fa-solid fa-location-dot text-red-600"></i>
                <span><?= esc($lhp['desa'] ?? '-') ?>, Kec. <?= esc($lhp['kecamatan'] ?? '-') ?></span>
            </div>
        </div>
    </div>

    <!-- Sections Detail Data -->
    <?php foreach ($sections as $title => $sectionData): ?>
        <section class="rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 shadow-xs">
            <h2 class="mb-4 text-base font-bold text-slate-800 flex items-center gap-2 pb-3 border-b border-slate-100">
                <i class="fa-solid <?= esc($sectionData['icon']) ?> text-red-700 text-sm"></i>
                <?= esc($title) ?>
            </h2>

            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <?php foreach ($sectionData['fields'] as $field => $label): ?>
                    <div class="rounded-xl bg-slate-50/70 p-3.5 border border-slate-100">
                        <dt class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <?= esc($label) ?>
                        </dt>
                        <dd class="mt-1.5 whitespace-pre-line text-sm font-semibold text-slate-800">
                            <?php if (in_array($field, ['ada_dugaan_pelanggaran', 'ada_potensi_sengketa'], true)): ?>
                                <?php $isYes = (int) ($lhp[$field] ?? 0) === 1; ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-bold
                                    <?= $isYes ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-slate-100 text-slate-600' ?>">
                                    <i class="fa-solid <?= $isYes ? 'fa-triangle-exclamation text-[10px]' : 'fa-check text-[10px]' ?>"></i>
                                    <?= $isYes ? 'Ya, Ada' : 'Tidak Ada' ?>
                                </span>
                            <?php elseif ($field === 'status'): ?>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    <?= $isDikirim
                                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20'
                                        : 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20' ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $isDikirim ? 'bg-emerald-500' : 'bg-amber-500' ?>"></span>
                                    <?= esc($lhp[$field] ?? '-') ?>
                                </span>
                            <?php else: ?>
                                <?= $formatValue($lhp[$field] ?? null) ?>
                            <?php endif; ?>
                        </dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </section>
    <?php endforeach; ?>

    <!-- Lampiran Foto Bukti -->
    <section class="rounded-2xl border border-slate-200/80 bg-white p-5 sm:p-6 shadow-xs">
        <h2 class="mb-4 text-base font-bold text-slate-800 flex items-center gap-2 pb-3 border-b border-slate-100">
            <i class="fa-solid fa-camera text-red-700 text-sm"></i>
            Lampiran Foto Bukti Pengawasan
        </h2>

        <?php if (!empty($lampiran)): ?>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($lampiran as $file): ?>
                    <?php $imageUrl = base_url('lhp/lampiran/' . $file['id']); ?>
                    <figure class="group overflow-hidden rounded-xl border border-slate-200 bg-slate-50 hover:shadow-md transition-all duration-200">
                        <a href="<?= esc($imageUrl) ?>" target="_blank" rel="noopener noreferrer" class="block relative overflow-hidden bg-slate-100">
                            <img
                                src="<?= esc($imageUrl) ?>"
                                alt="<?= esc($file['nama_asli'] ?? 'Foto bukti pengawasan') ?>"
                                loading="lazy"
                                class="h-56 w-full object-cover group-hover:scale-105 transition-transform duration-300"
                            >
                            <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-sm font-semibold gap-1.5">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                                <span>Lihat Penuh</span>
                            </div>
                        </a>
                        <figcaption class="border-t border-slate-200 bg-white px-3.5 py-2.5">
                            <span class="block truncate text-xs font-bold text-slate-800" title="<?= esc($file['nama_asli'] ?? $file['nama_file']) ?>">
                                <?= esc($file['nama_asli'] ?? $file['nama_file']) ?>
                            </span>
                            <span class="text-[11px] text-slate-400 mt-0.5 block">
                                <?= esc($file['tipe_file'] ?? '') ?>
                                <?php if (isset($file['ukuran_file'])): ?>
                                    &bull; <?= number_format((int) $file['ukuran_file'] / 1024, 1) ?> KB
                                <?php endif; ?>
                            </span>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rounded-xl bg-slate-50/80 border border-dashed border-slate-200 p-8 text-center">
                <i class="fa-regular fa-image text-slate-300 text-3xl mb-2"></i>
                <p class="text-sm font-medium text-slate-600">Tidak ada lampiran foto bukti.</p>
                <p class="text-xs text-slate-400 mt-0.5">Laporan ini dibuat tanpa mengunggah berkas foto pendukung.</p>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= esc(session()->getFlashdata('success'), 'js') ?>',
            confirmButtonColor: '#b91c1c',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-slate-100',
                confirmButton: 'px-5 py-2.5 rounded-xl font-medium shadow-md'
            }
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= esc(session()->getFlashdata('error'), 'js') ?>',
            confirmButtonColor: '#b91c1c',
            customClass: {
                popup: 'rounded-2xl shadow-2xl border border-slate-100',
                confirmButton: 'px-5 py-2.5 rounded-xl font-medium shadow-md'
            }
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>
