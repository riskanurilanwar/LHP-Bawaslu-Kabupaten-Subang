
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php

    $lhp = $lhp ?? [];
    $lampiran = $lampiran ?? [];

    $isEdit = !empty($lhp);
    $assignments = $assignments ?? [];
    $hasFixedAssignment = !empty($lhp['assignment_id'])
        || (!$isEdit && !empty($assignments));
    $selectedAssignmentId = old('assignment_id', $assignments[0]['id'] ?? '');
    $selectedAssignment = null;
    foreach ($assignments as $assignment) {
        if ((string) $assignment['id'] === (string) $selectedAssignmentId) {
            $selectedAssignment = $assignment;
            break;
        }
    }

    $formAction = $isEdit
        ? base_url('lhp/update/' . $lhp['id'])
        : base_url('lhp/simpan');

    $value = static function ($field, $default = '') use ($lhp) {
        return old($field, $lhp[$field] ?? $default);
    };

    $hasViolation = $value('ada_dugaan_pelanggaran', '0') == '1';

?>

<div class="space-y-6">

    <!-- Header Halaman -->
    <div>
        <a href="<?= base_url('lhp') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-red-700 transition-colors">
            <i class="fa-solid fa-arrow-left text-[11px]"></i>
            <span>Kembali ke Daftar LHP</span>
        </a>

        <div class="mt-2 flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                <p class="text-xs font-bold uppercase tracking-wider text-red-700">Formulir Model A.1</p>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
                <i class="fa-solid <?= $isEdit ? 'fa-file-pen' : 'fa-file-circle-plus' ?> text-red-700"></i>
                <?= $isEdit ? 'Edit Laporan Hasil Pengawasan' : 'Tambah Laporan Hasil Pengawasan' ?>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500">
                Formulir Model A — Laporan Hasil Pengawasan Pemilu Bawaslu Kabupaten Subang.
            </p>
        </div>

        <?php if (! $isEdit) : ?>
            <div class="mt-3.5 rounded-2xl border border-blue-200 bg-blue-50/80 p-3.5 text-xs text-blue-900 flex items-center gap-2.5">
                <i class="fa-solid fa-circle-info text-blue-600 text-sm shrink-0"></i>
                <span>Nomor LHP digenerate otomatis oleh sistem saat disimpan dengan format: <strong>nomor urut / LHP / PM.01.00 / bulan / tahun</strong>.</span>
            </div>
        <?php endif; ?>
    </div>

    <form
        action="<?= $formAction ?>"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        <?= csrf_field() ?>

        <!-- ====================================== -->
        <!-- PENUGASAN DARI PIMPINAN (JIKA ADA)    -->
        <!-- ====================================== -->

        <?php if (!empty($assignments) && !$isEdit) : ?>
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50/60 rounded-2xl border border-blue-200/90 p-5 sm:p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-bold shadow-xs">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <div>
                        <label for="assignment_id" class="block text-sm font-bold text-blue-950">
                            Penugasan Resmi dari Pimpinan
                        </label>
                        <p class="text-xs text-blue-800">
                            Pilih penugasan aktif Anda untuk mengisi otomatis tahapan dan kecamatan yang diawasi.
                        </p>
                    </div>
                </div>

                <select id="assignment_id" name="assignment_id" required
                        class="w-full border border-blue-300 rounded-xl px-4 py-2.5 bg-white text-sm text-slate-800 font-medium outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-600 transition-all"
                        data-assignment-select>
                    <option value="">Pilih penugasan yang sesuai</option>
                    <?php foreach ($assignments as $assignment) : ?>
                        <option value="<?= esc($assignment['id']) ?>"
                                data-tahapan="<?= esc($assignment['tahapan']) ?>"
                                data-wilayah="<?= esc($assignment['wilayah']) ?>"
                                data-nama="<?= esc($assignment['nama_pengguna']) ?>"
                                <?= (string) $selectedAssignmentId === (string) $assignment['id'] ? 'selected' : '' ?>>
                            <?= esc($assignment['tahapan'] . ' — ' . $assignment['wilayah'] . ' (' . $assignment['nama_pengguna'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <!-- ====================================== -->
        <!-- I. DATA PENGAWAS PEMILIHAN            -->
        <!-- ====================================== -->

        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-7">

            <h2 class="text-base font-bold text-slate-800 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-user-shield text-red-700 text-sm"></i>
                I. Data Pengawas Pemilihan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Tahapan yang Diawasi <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="text"
                        name="tahapan"
                        value="<?= esc($value('tahapan', $selectedAssignment['tahapan'] ?? '')) ?>"
                        required
                        placeholder="Contoh: Pemutakhiran Data Pemilih"
                        <?= $hasFixedAssignment ? 'readonly data-assignment-field="tahapan"' : '' ?>
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all <?= $hasFixedAssignment ? 'bg-slate-100 text-slate-600 cursor-not-allowed' : '' ?>"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nama Pelaksana Tugas Pengawasan <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_pengawas"
                        value="<?= esc(
                            $value(
                                'nama_pengawas',
                                $selectedAssignment['nama_pengguna'] ?? session()->get('nama')
                            )
                        ) ?>"
                        required
                        placeholder="Nama lengkap pengawas"
                        <?= $hasFixedAssignment ? 'readonly' : '' ?>
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all <?= $hasFixedAssignment ? 'bg-slate-100 text-slate-600 cursor-not-allowed' : '' ?>"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Jabatan Kedinasan <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="text"
                        name="jabatan"
                        value="<?= esc(old('jabatan', $lhp['jabatan_pengawas'] ?? '')) ?>"
                        required
                        placeholder="Contoh: Anggota Panwaslu Kecamatan Subang"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nomor Surat Perintah Tugas (SPT)
                    </label>

                    <input
                        type="text"
                        name="nomor_spt"
                        value="<?= esc(old('nomor_spt', $lhp['nomor_surat_tugas'] ?? '')) ?>"
                        placeholder="Contoh: 012/SPT/BAWASLU-SBG/2026"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Alamat Pengawas
                    </label>

                    <textarea
                        name="alamat_pengawas"
                        rows="2"
                        placeholder="Alamat domisili atau kantor sekretariat pengawas"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('alamat_pengawas')) ?></textarea>
                </div>

            </div>

        </div>

        <!-- ====================================== -->
        <!-- II. KEGIATAN PENGAWASAN               -->
        <!-- ====================================== -->

        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-7">

            <h2 class="text-base font-bold text-slate-800 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass-chart text-red-700 text-sm"></i>
                II. Kegiatan Pengawasan
            </h2>

            <div class="space-y-4">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Bentuk Pengawasan <span class="text-red-600">*</span>
                    </label>

                    <select
                        name="bentuk_pengawasan"
                        required
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                        <option value="">Pilih Bentuk Pengawasan</option>
                        <option value="Langsung" <?= $value('bentuk_pengawasan') === 'Langsung' ? 'selected' : '' ?>>
                            Langsung
                        </option>
                        <option value="Tidak Langsung" <?= $value('bentuk_pengawasan') === 'Tidak Langsung' ? 'selected' : '' ?>>
                            Tidak Langsung
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Tujuan Pengawasan <span class="text-red-600">*</span>
                    </label>

                    <textarea
                        name="tujuan_pengawasan"
                        rows="2"
                        required
                        placeholder="Contoh: Memastikan proses verifikasi faktual berjalan sesuai dengan PKPU"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('tujuan_pengawasan')) ?></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Sasaran Pengawasan <span class="text-red-600">*</span>
                    </label>

                    <textarea
                        name="sasaran_pengawasan"
                        rows="2"
                        required
                        placeholder="Contoh: Petugas Pemutakhiran Data Pemilih (Pantarlih)"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('sasaran_pengawasan')) ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Waktu Pengawasan <span class="text-red-600">*</span>
                        </label>

                        <input
                            type="datetime-local"
                            name="waktu_pengawasan"
                            value="<?= esc($value('waktu_pengawasan')) ?>"
                            required
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tempat Pengawasan <span class="text-red-600">*</span>
                        </label>

                        <input
                            type="text"
                            name="tempat_pengawasan"
                            value="<?= esc($value('tempat_pengawasan')) ?>"
                            required
                            placeholder="Contoh: Kantor Sekretariat PPS Desa Sukamulya"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                </div>

            </div>

        </div>

        <!-- Wilayah Pengawasan -->
        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-7">

            <h2 class="text-base font-bold text-slate-800 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-map-location-dot text-red-700 text-sm"></i>
                Wilayah Pengawasan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kecamatan <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="text"
                        name="kecamatan"
                        value="<?= esc($value('kecamatan', $selectedAssignment['wilayah'] ?? '')) ?>"
                        required
                        placeholder="Nama Kecamatan"
                        <?= $hasFixedAssignment ? 'readonly data-assignment-field="wilayah"' : '' ?>
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all <?= $hasFixedAssignment ? 'bg-slate-100 text-slate-600 cursor-not-allowed' : '' ?>"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Desa / Kelurahan <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="text"
                        name="desa"
                        value="<?= esc($value('desa')) ?>"
                        required
                        placeholder="Nama Desa / Kelurahan"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        TPS (Jika ada)
                    </label>

                    <input
                        type="text"
                        name="tps"
                        value="<?= esc($value('tps')) ?>"
                        placeholder="Contoh: TPS 005"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    >
                </div>

            </div>

        </div>

        <!-- ====================================== -->
        <!-- III. URAIAN HASIL PENGAWASAN          -->
        <!-- ====================================== -->

        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-7">

            <h2 class="text-base font-bold text-slate-800 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-file-lines text-red-700 text-sm"></i>
                III. Uraian Singkat Hasil Pengawasan
            </h2>
            <p class="text-xs text-slate-500 mb-4">
                Deskripsikan jalannya pengawasan, kronologis kejadian, situasi lapangan, dan temuan penting secara rinci.
            </p>

            <textarea
                name="uraian_hasil"
                rows="6"
                required
                placeholder="Tuliskan hasil pengawasan secara lengkap, kronologis, dan faktual..."
                class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-3 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all leading-relaxed"
            ><?= esc($value('uraian_hasil')) ?></textarea>

        </div>

        <!-- ====================================== -->
        <!-- IV. INFORMASI DUGAAN PELANGGARAN      -->
        <!-- ====================================== -->

        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-7">

            <h2 class="text-base font-bold text-slate-800 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-red-700 text-sm"></i>
                IV. Informasi Dugaan Pelanggaran
            </h2>

            <div class="mb-5 p-4 rounded-xl bg-slate-50/80 border border-slate-200/60">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                    Apakah terdapat dugaan pelanggaran dalam pengawasan ini?
                </label>

                <div class="flex gap-4">
                    <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-300 bg-white cursor-pointer hover:bg-slate-50 text-sm font-semibold text-slate-800 has-[:checked]:border-red-500 has-[:checked]:bg-red-50 has-[:checked]:text-red-700 transition-all">
                        <input
                            type="radio"
                            name="ada_dugaan_pelanggaran"
                            value="1"
                            <?= $value('ada_dugaan_pelanggaran') == '1' ? 'checked' : '' ?>
                            class="text-red-600 focus:ring-red-500"
                        >
                        <span>Ya, Ada Dugaan Pelanggaran</span>
                    </label>

                    <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-300 bg-white cursor-pointer hover:bg-slate-50 text-sm font-semibold text-slate-800 has-[:checked]:border-slate-400 has-[:checked]:bg-slate-100 has-[:checked]:text-slate-900 transition-all">
                        <input
                            type="radio"
                            name="ada_dugaan_pelanggaran"
                            value="0"
                            <?= $value('ada_dugaan_pelanggaran', '0') == '0' ? 'checked' : '' ?>
                            class="text-red-600 focus:ring-red-500"
                        >
                        <span>Tidak Ada</span>
                    </label>
                </div>
            </div>

            <fieldset
                id="informasiDugaanPelanggaran"
                <?= $hasViolation ? '' : 'hidden disabled' ?>
                class="space-y-5 pt-3 border-t border-slate-100"
            >

                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs">1</span>
                    Peristiwa Kejadian
                </h3>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Uraian Peristiwa
                    </label>

                    <textarea
                        name="peristiwa_pelanggaran"
                        rows="2"
                        placeholder="Jelaskan peristiwa dugaan pelanggaran yang terjadi"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('peristiwa_pelanggaran')) ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tempat Kejadian
                        </label>

                        <input
                            type="text"
                            name="tempat_kejadian"
                            value="<?= esc($value('tempat_kejadian')) ?>"
                            placeholder="Lokasi spesifik kejadian"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Waktu Kejadian
                        </label>

                        <input
                            type="datetime-local"
                            name="waktu_kejadian"
                            value="<?= esc($value('waktu_kejadian')) ?>"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Pelaku
                        </label>

                        <input
                            type="text"
                            name="pelaku"
                            value="<?= esc($value('pelaku')) ?>"
                            placeholder="Nama atau identitas terduga pelaku"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Alamat Pelaku
                        </label>

                        <input
                            type="text"
                            name="alamat_pelaku"
                            value="<?= esc($value('alamat_pelaku')) ?>"
                            placeholder="Alamat atau tempat tinggal pelaku"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                </div>

                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 pt-2">
                    <span class="w-5 h-5 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs">2</span>
                    Saksi-saksi
                </h3>

                <?php for ($i = 1; $i <= 2; $i++) : ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50/70 border border-slate-100">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nama Saksi <?= $i ?>
                            </label>

                            <input
                                type="text"
                                name="nama_saksi_<?= $i ?>"
                                value="<?= esc($value('nama_saksi_' . $i)) ?>"
                                placeholder="Nama saksi ke-<?= $i ?>"
                                class="w-full border border-slate-300 bg-white rounded-xl px-4 py-2 text-sm text-slate-800 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Alamat Saksi <?= $i ?>
                            </label>

                            <input
                                type="text"
                                name="alamat_saksi_<?= $i ?>"
                                value="<?= esc($value('alamat_saksi_' . $i)) ?>"
                                placeholder="Alamat saksi ke-<?= $i ?>"
                                class="w-full border border-slate-300 bg-white rounded-xl px-4 py-2 text-sm text-slate-800 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                            >
                        </div>
                    </div>
                <?php endfor; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-2">
                            <span class="w-5 h-5 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs">3</span>
                            Alat Bukti
                        </h3>
                        <textarea
                            name="alat_bukti"
                            rows="3"
                            placeholder="Tuliskan alat bukti yang ditemukan..."
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        ><?= esc($value('alat_bukti')) ?></textarea>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-2">
                            <span class="w-5 h-5 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs">4</span>
                            Barang Bukti
                        </h3>
                        <textarea
                            name="barang_bukti"
                            rows="3"
                            placeholder="Tuliskan barang bukti yang diamankan..."
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        ><?= esc($value('barang_bukti')) ?></textarea>
                    </div>
                </div>

                <div class="pt-2">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-2">
                        <span class="w-5 h-5 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs">5</span>
                        Uraian Singkat Dugaan Pelanggaran
                    </h3>
                    <textarea
                        name="uraian_dugaan_pelanggaran"
                        rows="3"
                        placeholder="Uraikan alur pelanggaran secara ringkas dan lugas..."
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('uraian_dugaan_pelanggaran')) ?></textarea>
                </div>

                <div class="pt-2">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-2">
                        <span class="w-5 h-5 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs">6</span>
                        Fakta dan Keterangan
                    </h3>
                    <textarea
                        name="fakta_keterangan"
                        rows="3"
                        placeholder="Fakta hukum dan keterangan saksi/pihak terkait di lapangan..."
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('fakta_keterangan')) ?></textarea>
                </div>

                <div class="pt-2">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-2">
                        <span class="w-5 h-5 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs">7</span>
                        Analisa Dugaan Pelanggaran
                    </h3>
                    <textarea
                        name="analisa"
                        rows="3"
                        placeholder="Analisa keterpenuhan unsur pasal dan regulasi pemilu..."
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('analisa')) ?></textarea>
                </div>

            </fieldset>

        </div>

        <!-- ====================================== -->
        <!-- V. INFORMASI POTENSI SENGKETA         -->
        <!-- ====================================== -->

        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-7">

            <h2 class="text-base font-bold text-slate-800 mb-5 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-scale-balanced text-red-700 text-sm"></i>
                V. Informasi Potensi Sengketa
            </h2>

            <div class="mb-5 p-4 rounded-xl bg-slate-50/80 border border-slate-200/60">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">
                    Apakah terdapat potensi sengketa proses pemilu?
                </label>

                <div class="flex gap-4">
                    <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-300 bg-white cursor-pointer hover:bg-slate-50 text-sm font-semibold text-slate-800 has-[:checked]:border-red-500 has-[:checked]:bg-red-50 has-[:checked]:text-red-700 transition-all">
                        <input
                            type="radio"
                            name="ada_potensi_sengketa"
                            value="1"
                            required
                            <?= $value('ada_potensi_sengketa', '0') == '1' ? 'checked' : '' ?>
                            class="text-red-600 focus:ring-red-500"
                        >
                        <span>Ya, Ada Potensi Sengketa</span>
                    </label>

                    <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-300 bg-white cursor-pointer hover:bg-slate-50 text-sm font-semibold text-slate-800 has-[:checked]:border-slate-400 has-[:checked]:bg-slate-100 has-[:checked]:text-slate-900 transition-all">
                        <input
                            type="radio"
                            name="ada_potensi_sengketa"
                            value="0"
                            required
                            <?= $value('ada_potensi_sengketa', '0') == '0' ? 'checked' : '' ?>
                            class="text-red-600 focus:ring-red-500"
                        >
                        <span>Tidak Ada</span>
                    </label>
                </div>
            </div>

            <fieldset
                id="informasiPotensiSengketa"
                <?= $value('ada_potensi_sengketa', '0') == '1' ? '' : 'hidden disabled' ?>
                class="space-y-4 pt-3 border-t border-slate-100"
            >
                <div>
                    <label for="peserta_sengketa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Peserta Pemilu yang Bersengketa
                    </label>
                    <textarea
                        id="peserta_sengketa"
                        name="peserta_sengketa"
                        rows="2"
                        placeholder="Identitas peserta pemilu"
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('peserta_sengketa')) ?></textarea>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="tempat_sengketa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Tempat Kejadian Sengketa
                        </label>
                        <input
                            id="tempat_sengketa"
                            type="text"
                            name="tempat_sengketa"
                            value="<?= esc($value('tempat_sengketa')) ?>"
                            placeholder="Lokasi terjadinya potensi sengketa"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                    <div>
                        <label for="waktu_sengketa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Waktu Kejadian
                        </label>
                        <input
                            id="waktu_sengketa"
                            type="datetime-local"
                            name="waktu_sengketa"
                            value="<?= esc(str_replace(' ', 'T', substr((string) $value('waktu_sengketa'), 0, 16))) ?>"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                    <div>
                        <label for="bentuk_objek_sengketa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Bentuk Objek Sengketa
                        </label>
                        <input
                            id="bentuk_objek_sengketa"
                            type="text"
                            name="bentuk_objek_sengketa"
                            value="<?= esc($value('bentuk_objek_sengketa')) ?>"
                            placeholder="Contoh: Berita Acara / Surat Keputusan KPU"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                    <div>
                        <label for="tanggal_objek_dikeluarkan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Hari/Tanggal Objek Dikeluarkan
                        </label>
                        <input
                            id="tanggal_objek_dikeluarkan"
                            type="date"
                            name="tanggal_objek_dikeluarkan"
                            value="<?= esc($value('tanggal_objek_dikeluarkan')) ?>"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="objek_sengketa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Identitas Objek Sengketa
                        </label>
                        <textarea
                            id="objek_sengketa"
                            name="objek_sengketa"
                            rows="2"
                            placeholder="Nomor surat, judul dokumen, atau identitas ketetapan objek sengketa"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        ><?= esc($value('objek_sengketa')) ?></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="kerugian_langsung" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                            Kerugian Langsung yang Dialami
                        </label>
                        <textarea
                            id="kerugian_langsung"
                            name="kerugian_langsung"
                            rows="2"
                            placeholder="Jelaskan kerugian materil atau immateril yang diderita peserta"
                            class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                        ><?= esc($value('kerugian_langsung')) ?></textarea>
                    </div>
                </div>

                <div>
                    <label for="uraian_sengketa" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Uraian Singkat Potensi Sengketa
                    </label>
                    <textarea
                        id="uraian_sengketa"
                        name="uraian_sengketa"
                        rows="3"
                        placeholder="Penjelasan kronologi singkat mengenai potensi timbulnya sengketa proses..."
                        class="w-full border border-slate-300 bg-slate-50/70 rounded-xl px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                    ><?= esc($value('uraian_sengketa')) ?></textarea>
                </div>
            </fieldset>
        </div>

        <!-- ====================================== -->
        <!-- FOTO BUKTI PENGAWASAN                 -->
        <!-- ====================================== -->

        <div class="bg-white rounded-2xl shadow-xs border border-slate-200/80 p-6 sm:p-7">

            <h2 class="text-base font-bold text-slate-800 mb-1 flex items-center gap-2">
                <i class="fa-solid fa-camera text-red-700 text-sm"></i>
                Lampiran Foto Bukti Pengawasan
            </h2>

            <p class="text-xs text-slate-500 mb-4">
                Unggah dokumentasi visual kegiatan pengawasan lapangan. Anda dapat memilih beberapa foto sekaligus (JPG, PNG, atau WEBP, maks 2 MB per file).
            </p>

            <div class="p-5 rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50/60 hover:bg-slate-50 hover:border-red-400 transition-colors">
                <input
                    id="foto_bukti"
                    type="file"
                    name="foto_bukti[]"
                    multiple
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer"
                >
            </div>

            <ul id="daftarFotoTerpilih" class="mt-3.5 space-y-1.5 text-xs text-slate-600" aria-live="polite"></ul>

            <?php if ($lampiran !== []) : ?>
                <div class="mt-5 border-t border-slate-100 pt-4">
                    <h3 class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-700">
                        Lampiran yang sudah tersimpan (<?= count($lampiran) ?> foto)
                    </h3>
                    <ul class="space-y-1 text-xs text-slate-600">
                        <?php foreach ($lampiran as $file) : ?>
                            <li class="flex items-center gap-2">
                                <i class="fa-regular fa-image text-slate-400"></i>
                                <span><?= esc($file['nama_asli'] ?? 'Lampiran') ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="mt-2 text-[11px] text-slate-400">
                        * Foto baru yang diunggah akan otomatis ditambahkan ke daftar lampiran LHP ini.
                    </p>
                </div>
            <?php endif; ?>

        </div>

        <!-- ====================================== -->
        <!-- ACTION BUTTONS                        -->
        <!-- ====================================== -->

        <div class="flex items-center justify-end gap-3 pt-2">

            <a
                href="<?= base_url('lhp') ?>"
                class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors"
            >
                <i class="fa-solid fa-xmark text-xs"></i>
                <span>Batal</span>
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-red-950/20 hover:from-red-700 hover:to-red-800 transition-all cursor-pointer"
            >
                <i class="fa-solid fa-floppy-disk text-xs"></i>
                <span><?= $isEdit ? 'Simpan Perubahan LHP' : 'Simpan Dokumen LHP' ?></span>
            </button>

        </div>

    </form>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    (() => {
        const penugasanSelect = document.querySelector(
            '[data-assignment-select]'
        );
        const tahapanField = document.querySelector(
            '[data-assignment-field="tahapan"]'
        );
        const wilayahField = document.querySelector(
            '[data-assignment-field="wilayah"]'
        );
        const namaPengawasField = document.querySelector(
            '[name="nama_pengawas"]'
        );

        const perbaruiPenugasan = () => {
            if (!penugasanSelect) {
                return;
            }

            const pilihanPenugasan = penugasanSelect.selectedOptions[0];
            tahapanField.value = pilihanPenugasan?.dataset.tahapan ?? '';
            wilayahField.value = pilihanPenugasan?.dataset.wilayah ?? '';
            namaPengawasField.value = pilihanPenugasan?.dataset.nama ?? '';
        };

        penugasanSelect?.addEventListener('change', perbaruiPenugasan);
        perbaruiPenugasan();

        const pilihan = document.querySelectorAll(
            'input[name="ada_dugaan_pelanggaran"]'
        );
        const informasi = document.getElementById(
            'informasiDugaanPelanggaran'
        );

        const perbaruiInformasi = () => {
            const adaPelanggaran = document.querySelector(
                'input[name="ada_dugaan_pelanggaran"]:checked'
            )?.value === '1';

            informasi.hidden = !adaPelanggaran;
            informasi.disabled = !adaPelanggaran;
        };

        pilihan.forEach((radio) => {
            radio.addEventListener('change', perbaruiInformasi);
        });

        const pilihanSengketa = document.querySelectorAll(
            'input[name="ada_potensi_sengketa"]'
        );
        const informasiSengketa = document.getElementById(
            'informasiPotensiSengketa'
        );

        const perbaruiInformasiSengketa = () => {
            const adaSengketa = document.querySelector(
                'input[name="ada_potensi_sengketa"]:checked'
            )?.value === '1';

            informasiSengketa.hidden = !adaSengketa;
            informasiSengketa.disabled = !adaSengketa;
        };

        pilihanSengketa.forEach((radio) => {
            radio.addEventListener('change', perbaruiInformasiSengketa);
        });

        const inputFoto = document.getElementById('foto_bukti');
        const daftarFoto = document.getElementById('daftarFotoTerpilih');

        inputFoto.addEventListener('change', () => {
            daftarFoto.replaceChildren();

            Array.from(inputFoto.files).forEach((file) => {
                const item = document.createElement('li');
                item.className = 'flex items-center gap-2';
                const ukuranMb = (file.size / (1024 * 1024)).toFixed(2);
                item.innerHTML = `<i class="fa-solid fa-file-image text-red-500"></i> <span>${file.name}</span> <span class="text-slate-400 font-medium">(${ukuranMb} MB)</span>`;
                daftarFoto.appendChild(item);
            });

            if (inputFoto.files.length > 0) {
                const ringkasan = document.createElement('li');
                ringkasan.className = 'mt-2 list-none font-bold text-emerald-700 flex items-center gap-1.5';
                ringkasan.innerHTML = `<i class="fa-solid fa-check-circle"></i> <span>${inputFoto.files.length} foto siap diunggah saat disimpan.</span>`;
                daftarFoto.appendChild(ringkasan);
            }
        });
    })();
</script>
<?= $this->endSection() ?>
