<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<?php
$fieldGroups = [
    'Kop dan Regulasi' => [
        'organization_name' => 'Nama instansi',
        'organization_region' => 'Wilayah instansi',
        'organization_address' => 'Alamat instansi',
        'organization_phone' => 'Nomor telepon',
        'organization_email' => 'Alamat email',
        'contact_phone_prefix' => 'Awalan label telepon',
        'contact_email_prefix' => 'Awalan label email',
        'form_model' => 'Nama formulir',
    ],
    'Judul dan Data Pengawas' => [
        'document_title' => 'Judul dokumen',
        'number_label' => 'Label nomor dokumen',
        'section_identity' => 'Judul Bagian I',
        'label_stage' => 'Label tahapan yang diawasi',
        'label_supervisor' => 'Label nama pelaksana pengawasan',
        'label_position' => 'Label jabatan',
        'label_task_order_number' => 'Label nomor surat tugas',
        'label_task_order_date' => 'Label tanggal surat tugas',
        'label_address' => 'Label alamat',
    ],
    'Kegiatan dan Hasil Pengawasan' => [
        'section_activity' => 'Judul Bagian II',
        'label_activity_form' => 'Label bentuk pengawasan',
        'label_activity_purpose' => 'Label tujuan pengawasan',
        'label_activity_target' => 'Label sasaran pengawasan',
        'label_activity_time' => 'Label waktu pengawasan',
        'label_activity_place' => 'Label tempat pengawasan',
        'label_district' => 'Label kecamatan',
        'label_village' => 'Label desa / kelurahan',
        'label_polling_station' => 'Label TPS',
        'section_results' => 'Judul Bagian III',
    ],
    'Dugaan Pelanggaran dan Saksi' => [
        'section_violation' => 'Judul Bagian IV',
        'label_violation_yes_no' => 'Pertanyaan dugaan pelanggaran',
        'answer_yes' => 'Jawaban Ya',
        'answer_no' => 'Jawaban Tidak',
        'label_violation_event' => 'Label peristiwa',
        'label_violation_place' => 'Label tempat kejadian',
        'label_violation_time' => 'Label waktu kejadian',
        'label_violation_actor' => 'Label pelaku',
        'label_actor_address' => 'Label alamat pelaku',
        'label_evidence_tool' => 'Label alat bukti',
        'label_evidence_item' => 'Label barang bukti',
        'label_violation_description' => 'Label uraian dugaan pelanggaran',
        'label_violation_facts' => 'Label fakta dan keterangan',
        'label_violation_analysis' => 'Label analisis',
        'witness_heading' => 'Judul tabel saksi',
        'table_number' => 'Judul kolom nomor',
        'table_witness_name' => 'Judul kolom nama saksi',
        'table_witness_address' => 'Judul kolom alamat saksi',
    ],
    'Potensi Sengketa dan Lampiran' => [
        'section_dispute' => 'Judul Bagian V',
        'label_dispute_yes_no' => 'Pertanyaan potensi sengketa',
        'label_dispute_participant' => 'Label peserta pemilu',
        'label_dispute_place' => 'Label tempat kejadian sengketa',
        'label_dispute_time' => 'Label waktu kejadian sengketa',
        'label_dispute_object_type' => 'Label bentuk objek sengketa',
        'label_dispute_object_identity' => 'Label identitas objek sengketa',
        'label_dispute_object_date' => 'Label tanggal objek dikeluarkan',
        'label_dispute_loss' => 'Label kerugian langsung',
        'label_dispute_description' => 'Label uraian potensi sengketa',
        'attachment_heading' => 'Judul lampiran foto',
        'attachment_alt' => 'Teks alternatif foto lampiran',
        'empty_value' => 'Teks untuk data kosong',
    ],
    'Tanda Tangan' => [
        'signature_city' => 'Nama kota',
        'signature_date_separator' => 'Pemisah kota dan tanggal',
        'signature_title' => 'Jabatan penanda tangan',
    ],
];
$previewGroups = $fieldGroups;
?>

<div class="mx-auto max-w-5xl space-y-6">

    <!-- Header Halaman -->
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="w-2 h-2 rounded-full bg-red-600"></span>
            <p class="text-xs font-bold uppercase tracking-wider text-red-700">Pengaturan Administrator</p>
        </div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2.5">
            <i class="fa-solid fa-file-pen text-red-700"></i>
            Template Dokumen Cetak LHP
        </h1>
        <p class="mt-1 text-xs sm:text-sm text-slate-500">
            Sesuaikan redaksi baku, judul bab, dan penamaan kolom yang tercetak pada berkas fisik Formulir Model A.1.
        </p>
    </div>

    <!-- Informasi / Notice -->
    <div class="rounded-2xl border border-blue-200 bg-blue-50/80 p-4 text-xs sm:text-sm text-blue-900 flex items-start gap-3">
        <i class="fa-solid fa-circle-info text-blue-600 text-base mt-0.5 shrink-0"></i>
        <div>
            <p class="font-bold">Informasi Pengaturan Template</p>
            <p class="text-blue-800/90 mt-0.5">
                Pengaturan ini hanya mengubah redaksi label cetak dan tidak mempengaruhi data hasil pengawasan yang telah tersimpan. Logo kop resmi tetap menggunakan citra lambang Bawaslu yang berlaku.
            </p>
        </div>
    </div>

    <form action="<?= base_url('kelola-template-lhp/update') ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>

        <?php foreach ($fieldGroups as $group => $fields) : ?>
            <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs sm:p-7">
                <h2 class="mb-4 text-base font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <i class="fa-regular fa-folder text-red-700 text-sm"></i>
                    <?= esc($group) ?>
                </h2>

                <?php if ($group === 'Kop dan Regulasi') : ?>
                    <div class="mb-5 flex items-center gap-4 rounded-xl border border-slate-200 bg-slate-50/80 p-4">
                        <img
                            src="<?= base_url('assets/images/kop-bawaslu-subang.png') ?>"
                            alt="Logo Bawaslu Kabupaten Subang"
                            class="h-14 w-auto object-contain rounded-lg shadow-2xs"
                        >
                        <div class="text-xs text-slate-600">
                            <span class="font-bold text-slate-800 block">Kop Resmi Terintegrasi</span>
                            <span>Gambar kop logo instansi diterapkan secara baku di sudut kiri atas lembar cetak LHP.</span>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="grid gap-4 sm:grid-cols-2">
                    <?php foreach ($fields as $field => $label) : ?>
                        <div>
                            <label for="<?= esc($field) ?>" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                                <?= esc($label) ?>
                            </label>
                            <input
                                id="<?= esc($field) ?>"
                                name="<?= esc($field) ?>"
                                type="text"
                                maxlength="150"
                                required
                                value="<?= esc(old($field, $template[$field])) ?>"
                                data-preview="<?= esc($field) ?>"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50/70 px-4 py-2.5 text-sm text-slate-800 outline-none focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-100 transition-all"
                            >
                            <?php if (isset($errors[$field])) : ?>
                                <p class="mt-1 text-xs text-red-600 font-medium"><?= esc($errors[$field]) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>

        <!-- Pratinjau Teks Template -->
        <section class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-xs sm:p-7">
            <h2 class="mb-4 text-base font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-eye text-blue-600 text-sm"></i>
                Pratinjau Langsung Nilai Template
            </h2>
            <div class="space-y-5 rounded-xl border border-slate-200 bg-slate-50/50 p-5 font-mono text-xs">
                <?php foreach ($previewGroups as $group => $fields) : ?>
                    <div>
                        <h3 class="mb-2 border-b border-slate-200 pb-1 text-xs font-bold text-slate-700 uppercase tracking-wide">
                            <?= esc($group) ?>
                        </h3>
                        <div class="grid gap-x-6 gap-y-1.5 sm:grid-cols-2">
                            <?php foreach ($fields as $field => $label) : ?>
                                <p class="text-xs">
                                    <span class="text-slate-400 font-normal"><?= esc($label) ?>:</span>
                                    <span class="font-bold text-slate-800 whitespace-pre-line ml-1" data-preview-target="<?= esc($field) ?>"><?= esc(old($field, $template[$field])) ?></span>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Action Buttons -->
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row pt-2">
            <a href="<?= base_url('dashboard/admin') ?>" class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                <i class="fa-solid fa-xmark text-xs"></i>
                <span>Batal</span>
            </a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-red-950/20 hover:from-red-700 hover:to-red-800 transition-all">
                <i class="fa-solid fa-check text-xs"></i>
                <span>Simpan Perubahan Template</span>
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.querySelectorAll('[data-preview]').forEach((input) => {
        input.addEventListener('input', () => {
            const target = document.querySelector(
                `[data-preview-target="${input.dataset.preview}"]`
            );
            if (target) {
                target.textContent = input.value;
            }
        });
    });
</script>
<?= $this->endSection() ?>
