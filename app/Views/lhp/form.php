
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php

    $lhp = $lhp ?? [];
    $lampiran = $lampiran ?? [];

    $isEdit = !empty($lhp);

    $formAction = $isEdit
        ? base_url('lhp/update/' . $lhp['id'])
        : base_url('lhp/simpan');

    $value = static function ($field, $default = '') use ($lhp) {
        return old($field, $lhp[$field] ?? $default);
    };

    $hasViolation = $value('ada_dugaan_pelanggaran', '0') == '1';

?>

<div class="mb-6">

    <h1 class="text-2xl font-bold text-slate-800">
        <?= $isEdit ? 'Edit Laporan Hasil Pengawasan' : 'Tambah Laporan Hasil Pengawasan' ?>
    </h1>

    <p class="text-slate-500 mt-1">
        Formulir Model.A — Laporan Hasil Pengawasan Pemilu
    </p>
    <?php if (! $isEdit) : ?>
        <p class="mt-2 text-sm text-blue-700">
        Nomor LHP dibuat otomatis dengan format nomor urut[.huruf kecamatan]/LHP/bulan/tahun. Huruf kecamatan dicantumkan jika LHP diisi setelah tanggal pengawasan.
        </p>
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
    <!-- I. DATA PENGAWAS PEMILIHAN -->
    <!-- ====================================== -->

    <div class="bg-white rounded-xl shadow-sm border
                border-slate-200 p-6">

        <h2 class="text-lg font-semibold mb-5">
            I. Data Pengawas Pemilihan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>

                <label class="block text-sm font-medium mb-2">
                    Tahapan yang Diawasi
                </label>

                <input
                    type="text"
                    name="tahapan"
                    value="<?= esc($value('tahapan')) ?>"
                    required
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3
                           focus:ring-2 focus:ring-blue-500"
                >

            </div>

            <div>

                <label class="block text-sm font-medium mb-2">
                    Nama Pelaksana Tugas Pengawasan
                </label>

                <input
                    type="text"
                    name="nama_pengawas"
                    value="<?= esc(
                        $value(
                            'nama_pengawas',
                            session()->get('nama')
                        )
                    ) ?>"
                    required
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

            </div>

            <div>

                <label class="block text-sm font-medium mb-2">
                    Jabatan
                </label>

                <input
                    type="text"
                    name="jabatan"
                    value="<?= esc(
                                old('jabatan', $lhp['jabatan_pengawas'] ?? '')
                            ) ?>"
                    required
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

            </div>

            <div>

                <label class="block text-sm font-medium mb-2">
                    Nomor Surat Perintah Tugas
                </label>

                <input
                    type="text"
                    name="nomor_spt"
                    value="<?= esc(
                        old('nomor_spt', $lhp['nomor_surat_tugas'] ?? '')
                    ) ?>"
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

            </div>

            <div class="md:col-span-2">

                <label class="block text-sm font-medium mb-2">
                    Alamat
                </label>

                <textarea
                    name="alamat_pengawas"
                    rows="2"
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                ><?= esc($value('alamat_pengawas')) ?></textarea>

            </div>

        </div>

    </div>


    <!-- ====================================== -->
    <!-- II. KEGIATAN PENGAWASAN -->
    <!-- ====================================== -->

    <div class="bg-white rounded-xl shadow-sm border
                border-slate-200 p-6">

        <h2 class="text-lg font-semibold mb-5">
            II. Kegiatan Pengawasan
        </h2>

        <div class="space-y-5">

            <div>

                <label class="block text-sm font-medium mb-2">
                    Bentuk Pengawasan
                </label>

                <select
                    name="bentuk_pengawasan"
                    required
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                >

                    <option value="">
                        Pilih Bentuk Pengawasan
                    </option>

                    <option
                        value="Langsung"
                        <?= $value('bentuk_pengawasan') === 'Langsung'
                            ? 'selected'
                            : '' ?>
                    >
                        Langsung
                    </option>

                    <option
                        value="Tidak Langsung"
                        <?= $value('bentuk_pengawasan') === 'Tidak Langsung'
                            ? 'selected'
                            : '' ?>
                    >
                        Tidak Langsung
                    </option>

                </select>

            </div>

            <div>

                <label class="block text-sm font-medium mb-2">
                    Tujuan Pengawasan
                </label>

                <textarea
                    name="tujuan_pengawasan"
                    rows="3"
                    required
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                ><?= esc($value('tujuan_pengawasan')) ?></textarea>

            </div>

            <div>

                <label class="block text-sm font-medium mb-2">
                    Sasaran Pengawasan
                </label>

                <textarea
                    name="sasaran_pengawasan"
                    rows="3"
                    required
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                ><?= esc($value('sasaran_pengawasan')) ?></textarea>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Waktu Pengawasan
                    </label>

                    <input
                        type="datetime-local"
                        name="waktu_pengawasan"
                        value="<?= esc(
                            $value('waktu_pengawasan')
                        ) ?>"
                        required
                        class="w-full border border-slate-300
                               rounded-lg px-4 py-3"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Tempat Pengawasan
                    </label>

                    <input
                        type="text"
                        name="tempat_pengawasan"
                        value="<?= esc(
                            $value('tempat_pengawasan')
                        ) ?>"
                        required
                        class="w-full border border-slate-300
                               rounded-lg px-4 py-3"
                    >

                </div>

            </div>

        </div>

    </div>

    <!-- Wilayah Pengawasan -->

    <div class="bg-white rounded-xl shadow-sm border
                border-slate-200 p-6">

        <h2 class="text-lg font-semibold mb-5">
            Wilayah Pengawasan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>

                <label class="block text-sm font-medium mb-2">
                    Kecamatan
                </label>

                <input
                    type="text"
                    name="kecamatan"
                    value="<?= esc($value('kecamatan')) ?>"
                    required
                    class="w-full border border-slate-300
                        rounded-lg px-4 py-3"
                >

            </div>

            <div>

                <label class="block text-sm font-medium mb-2">
                    Desa / Kelurahan
                </label>

                <input
                    type="text"
                    name="desa"
                    value="<?= esc($value('desa')) ?>"
                    required
                    class="w-full border border-slate-300
                        rounded-lg px-4 py-3"
                >

            </div>

            <div>

                <label class="block text-sm font-medium mb-2">
                    TPS
                </label>

                <input
                    type="text"
                    name="tps"
                    value="<?= esc($value('tps')) ?>"
                    class="w-full border border-slate-300
                        rounded-lg px-4 py-3"
                >

            </div>

        </div>

    </div>


    <!-- ====================================== -->
    <!-- III. URAIAN HASIL PENGAWASAN -->
    <!-- ====================================== -->

    <div class="bg-white rounded-xl shadow-sm border
                border-slate-200 p-6">

        <h2 class="text-lg font-semibold mb-5">
            III. Uraian Singkat Hasil Pengawasan
        </h2>

        <textarea
            name="uraian_hasil"
            rows="6"
            required
            placeholder="Tuliskan hasil pengawasan..."
            class="w-full border border-slate-300
                   rounded-lg px-4 py-3"
        ><?= esc($value('uraian_hasil')) ?></textarea>

    </div>


    <!-- ====================================== -->
    <!-- IV. INFORMASI DUGAAN PELANGGARAN -->
    <!-- ====================================== -->

    <div class="bg-white rounded-xl shadow-sm border
                border-slate-200 p-6">

        <h2 class="text-lg font-semibold mb-5">
            IV. Informasi Dugaan Pelanggaran
        </h2>

        <div class="mb-6">

            <label class="block text-sm font-medium mb-3">
                Apakah terdapat dugaan pelanggaran?
            </label>

            <div class="flex gap-6">

                <label class="flex items-center gap-2">

                    <input
                        type="radio"
                        name="ada_dugaan_pelanggaran"
                        value="1"
                        <?= $value('ada_dugaan_pelanggaran') == '1'
                            ? 'checked'
                            : '' ?>
                    >

                    Ya

                </label>

                <label class="flex items-center gap-2">

                    <input
                        type="radio"
                        name="ada_dugaan_pelanggaran"
                        value="0"
                        <?= $value('ada_dugaan_pelanggaran', '0') == '0'
                            ? 'checked'
                            : '' ?>
                    >

                    Tidak

                </label>

            </div>

        </div>

        <fieldset
            id="informasiDugaanPelanggaran"
            <?= $hasViolation ? '' : 'hidden disabled' ?>
            class="space-y-5"
        >

            <h3 class="font-medium">
                1. Peristiwa
            </h3>

            <div>

                <label class="block text-sm font-medium mb-2">
                    Peristiwa
                </label>

                <textarea
                    name="peristiwa_pelanggaran"
                    rows="2"
                    class="w-full border border-slate-300
                           rounded-lg px-4 py-3"
                ><?= esc($value('peristiwa_pelanggaran')) ?></textarea>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Tempat Kejadian
                    </label>

                    <input
                        type="text"
                        name="tempat_kejadian"
                        value="<?= esc($value('tempat_kejadian')) ?>"
                        class="w-full border border-slate-300
                               rounded-lg px-4 py-3"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Waktu Kejadian
                    </label>

                    <input
                        type="datetime-local"
                        name="waktu_kejadian"
                        value="<?= esc($value('waktu_kejadian')) ?>"
                        class="w-full border border-slate-300
                               rounded-lg px-4 py-3"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Pelaku
                    </label>

                    <input
                        type="text"
                        name="pelaku"
                        value="<?= esc($value('pelaku')) ?>"
                        class="w-full border border-slate-300
                               rounded-lg px-4 py-3"
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Alamat Pelaku
                    </label>

                    <input
                        type="text"
                        name="alamat_pelaku"
                        value="<?= esc($value('alamat_pelaku')) ?>"
                        class="w-full border border-slate-300
                               rounded-lg px-4 py-3"
                    >

                </div>

            </div>

            <h3 class="font-medium pt-4">
                2. Saksi-saksi
            </h3>

            <?php for ($i = 1; $i <= 2; $i++) : ?>

                <div class="grid grid-cols-1 md:grid-cols-2
                            gap-5">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Nama Saksi <?= $i ?>
                        </label>

                        <input
                            type="text"
                            name="nama_saksi_<?= $i ?>"
                            value="<?= esc(
                                $value('nama_saksi_' . $i)
                            ) ?>"
                            class="w-full border border-slate-300
                                   rounded-lg px-4 py-3"
                        >

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Alamat Saksi <?= $i ?>
                        </label>

                        <input
                            type="text"
                            name="alamat_saksi_<?= $i ?>"
                            value="<?= esc(
                                $value('alamat_saksi_' . $i)
                            ) ?>"
                            class="w-full border border-slate-300
                                   rounded-lg px-4 py-3"
                        >

                    </div>

                </div>

            <?php endfor; ?>

            <h3 class="font-medium pt-4">
                3. Alat Bukti
            </h3>

            <textarea
                name="alat_bukti"
                rows="3"
                placeholder="Tuliskan alat bukti..."
                class="w-full border border-slate-300
                       rounded-lg px-4 py-3"
            ><?= esc($value('alat_bukti')) ?></textarea>

            <h3 class="font-medium pt-4">
                4. Barang Bukti
            </h3>

            <textarea
                name="barang_bukti"
                rows="3"
                placeholder="Tuliskan barang bukti..."
                class="w-full border border-slate-300
                       rounded-lg px-4 py-3"
            ><?= esc($value('barang_bukti')) ?></textarea>

            <h3 class="font-medium pt-4">
                5. Uraian Singkat Dugaan Pelanggaran
            </h3>

            <textarea
                name="uraian_dugaan_pelanggaran"
                rows="4"
                class="w-full border border-slate-300
                       rounded-lg px-4 py-3"
            ><?= esc(
                $value('uraian_dugaan_pelanggaran')
            ) ?></textarea>

            <h3 class="font-medium pt-4">
                6. Fakta dan Keterangan
            </h3>

            <textarea
                name="fakta_keterangan"
                rows="4"
                class="w-full border border-slate-300
                       rounded-lg px-4 py-3"
            ><?= esc($value('fakta_keterangan')) ?></textarea>

            <h3 class="font-medium pt-4">
                7. Analisa
            </h3>

            <textarea
                name="analisa"
                rows="4"
                class="w-full border border-slate-300
                       rounded-lg px-4 py-3"
            ><?= esc($value('analisa')) ?></textarea>

        </fieldset>

    </div>


    <!-- ====================================== -->
    <!-- V. INFORMASI POTENSI SENGKETA -->
    <!-- ====================================== -->

    <div class="bg-white rounded-xl shadow-sm border
                border-slate-200 p-6">

        <h2 class="text-lg font-semibold mb-5">
            V. Informasi Potensi Sengketa
        </h2>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-3">
                Apakah terdapat potensi sengketa?
            </label>

            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input
                        type="radio"
                        name="ada_potensi_sengketa"
                        value="1"
                        required
                        <?= $value('ada_potensi_sengketa', '0') == '1' ? 'checked' : '' ?>
                    >
                    Ya
                </label>

                <label class="flex items-center gap-2">
                    <input
                        type="radio"
                        name="ada_potensi_sengketa"
                        value="0"
                        required
                        <?= $value('ada_potensi_sengketa', '0') == '0' ? 'checked' : '' ?>
                    >
                    Tidak
                </label>
            </div>
        </div>

        <fieldset
            id="informasiPotensiSengketa"
            <?= $value('ada_potensi_sengketa', '0') == '1' ? '' : 'hidden disabled' ?>
            class="space-y-5"
        >
            <div>
                <label for="peserta_sengketa" class="block text-sm font-medium mb-2">
                    Peserta Pemilu
                </label>
                <textarea
                    id="peserta_sengketa"
                    name="peserta_sengketa"
                    rows="2"
                    class="w-full border border-slate-300 rounded-lg px-4 py-3"
                ><?= esc($value('peserta_sengketa')) ?></textarea>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="tempat_sengketa" class="block text-sm font-medium mb-2">
                        Tempat Kejadian
                    </label>
                    <input
                        id="tempat_sengketa"
                        type="text"
                        name="tempat_sengketa"
                        value="<?= esc($value('tempat_sengketa')) ?>"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3"
                    >
                </div>

                <div>
                    <label for="waktu_sengketa" class="block text-sm font-medium mb-2">
                        Waktu Kejadian
                    </label>
                    <input
                        id="waktu_sengketa"
                        type="datetime-local"
                        name="waktu_sengketa"
                        value="<?= esc(str_replace(' ', 'T', substr((string) $value('waktu_sengketa'), 0, 16))) ?>"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3"
                    >
                </div>

                <div>
                    <label for="bentuk_objek_sengketa" class="block text-sm font-medium mb-2">
                        Bentuk Objek Sengketa
                    </label>
                    <input
                        id="bentuk_objek_sengketa"
                        type="text"
                        name="bentuk_objek_sengketa"
                        value="<?= esc($value('bentuk_objek_sengketa')) ?>"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3"
                    >
                </div>

                <div>
                    <label for="objek_sengketa" class="block text-sm font-medium mb-2">
                        Identitas Objek Sengketa
                    </label>
                    <textarea
                        id="objek_sengketa"
                        name="objek_sengketa"
                        rows="2"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3"
                    ><?= esc($value('objek_sengketa')) ?></textarea>
                </div>

                <div>
                    <label for="tanggal_objek_dikeluarkan" class="block text-sm font-medium mb-2">
                        Hari/Tanggal Objek Dikeluarkan
                    </label>
                    <input
                        id="tanggal_objek_dikeluarkan"
                        type="date"
                        name="tanggal_objek_dikeluarkan"
                        value="<?= esc($value('tanggal_objek_dikeluarkan')) ?>"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3"
                    >
                </div>

                <div>
                    <label for="kerugian_langsung" class="block text-sm font-medium mb-2">
                        Kerugian Langsung
                    </label>
                    <textarea
                        id="kerugian_langsung"
                        name="kerugian_langsung"
                        rows="2"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3"
                    ><?= esc($value('kerugian_langsung')) ?></textarea>
                </div>
            </div>

            <div>
                <label for="uraian_sengketa" class="block text-sm font-medium mb-2">
                    Uraian Singkat Potensi Sengketa
                </label>
                <textarea
                    id="uraian_sengketa"
                    name="uraian_sengketa"
                    rows="4"
                    class="w-full border border-slate-300 rounded-lg px-4 py-3"
                ><?= esc($value('uraian_sengketa')) ?></textarea>
            </div>
        </fieldset>
    </div>


    <!-- ====================================== -->
    <!-- FOTO BUKTI PENGAWASAN -->
    <!-- ====================================== -->

    <div class="bg-white rounded-xl shadow-sm border
                border-slate-200 p-6">

        <h2 class="text-lg font-semibold mb-2">
            Lampiran Foto Bukti Pengawasan
        </h2>

        <p class="text-sm text-slate-500 mb-5">
            Tambahkan foto dokumentasi atau bukti pengawasan.
            Pilih beberapa foto sekaligus, atau pilih kembali untuk mengganti daftar foto yang belum disimpan.
        </p>

        <input
            id="foto_bukti"
            type="file"
            name="foto_bukti[]"
            multiple
            accept="image/jpeg,image/png,image/webp"
            class="w-full border border-slate-300
                   rounded-lg px-4 py-3"
        >

        <p class="text-xs text-slate-400 mt-2">
            Format yang didukung: JPG, PNG, dan WEBP.
            Maksimal setiap file 2 MB.
        </p>

        <ul id="daftarFotoTerpilih" class="mt-3 list-inside list-disc space-y-1 text-sm text-slate-600" aria-live="polite"></ul>

        <?php if ($lampiran !== []) : ?>
            <div class="mt-5 border-t border-slate-200 pt-4">
                <h3 class="mb-2 text-sm font-semibold text-slate-700">
                    Lampiran yang sudah tersimpan (<?= count($lampiran) ?>)
                </h3>
                <ul class="list-inside list-disc space-y-1 text-sm text-slate-600">
                    <?php foreach ($lampiran as $file) : ?>
                        <li><?= esc($file['nama_asli'] ?? 'Lampiran') ?></li>
                    <?php endforeach; ?>
                </ul>
                <p class="mt-2 text-xs text-slate-400">
                    Lampiran baru akan ditambahkan tanpa menghapus lampiran yang sudah tersimpan.
                </p>
            </div>
        <?php endif; ?>

    </div>


    <!-- ====================================== -->
    <!-- TOMBOL -->
    <!-- ====================================== -->

    <div class="flex justify-end gap-3">

        <a
            href="<?= base_url('lhp') ?>"
            class="px-5 py-3 rounded-lg border
                   border-slate-300 text-slate-600
                   hover:bg-slate-100"
        >
            Batal
        </a>

        <button
            type="submit"
            class="px-5 py-3 rounded-lg
                   bg-blue-600 hover:bg-blue-700
                   text-white font-medium"
        >

            <?= $isEdit ? 'Simpan Perubahan' : 'Simpan LHP' ?>

        </button>

    </div>

</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    (() => {
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
                const ukuranMb = (file.size / (1024 * 1024)).toFixed(2);
                item.textContent = `${file.name} (${ukuranMb} MB)`;
                daftarFoto.appendChild(item);
            });

            if (inputFoto.files.length > 0) {
                const ringkasan = document.createElement('li');
                ringkasan.className = 'mt-2 list-none font-medium text-slate-700';
                ringkasan.textContent = `${inputFoto.files.length} foto siap diunggah.`;
                daftarFoto.appendChild(ringkasan);
            }
        });
    })();
</script>
<?= $this->endSection() ?>
