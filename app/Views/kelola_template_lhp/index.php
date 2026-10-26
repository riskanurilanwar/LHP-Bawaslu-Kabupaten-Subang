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
        'regulation_attachment' => 'Teks lampiran regulasi',
        'regulation_name' => 'Nama peraturan',
        'regulation_number' => 'Nomor peraturan',
        'regulation_subject' => 'Tentang peraturan',
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
    <div>
        <p class="text-sm font-medium text-blue-700">Pengaturan Admin</p>
        <h1 class="mt-1 text-2xl font-bold text-slate-800">Template Dokumen LHP</h1>
        <p class="mt-1 text-sm text-slate-500">
            Ubah semua teks tetap, judul, dan label yang muncul pada dokumen cetak LHP.
        </p>
    </div>

    <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-900">
        Pengaturan ini hanya mengubah teks template dan tidak mengubah data laporan yang diinput. Logo kop tetap menggunakan gambar yang telah ditetapkan.
    </div>

    <form action="<?= base_url('kelola-template-lhp/update') ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>

        <?php foreach ($fieldGroups as $group => $fields) : ?>
            <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mb-5 text-lg font-semibold text-slate-800"><?= esc($group) ?></h2>
                <?php if ($group === 'Kop dan Regulasi') : ?>
                    <div class="mb-5 flex items-center gap-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <img
                            src="<?= base_url('assets/images/kop-bawaslu-subang.png') ?>"
                            alt="Logo Bawaslu Kabupaten Subang"
                            class="h-16 w-16 object-cover object-left"
                        >
                        <p class="text-sm text-slate-600">
                            Gambar kop yang telah ditetapkan digunakan di kiri atas dokumen cetak.
                        </p>
                    </div>
                <?php endif; ?>
                <div class="grid gap-5 sm:grid-cols-2">
                    <?php foreach ($fields as $field => $label) : ?>
                        <div>
                            <label for="<?= esc($field) ?>" class="mb-2 block text-sm font-medium text-slate-700">
                                <?= esc($label) ?>
                            </label>
                            <?php if (in_array($field, ['regulation_name', 'regulation_subject'], true)) : ?>
                                <textarea
                                    id="<?= esc($field) ?>"
                                    name="<?= esc($field) ?>"
                                    maxlength="150"
                                    required
                                    rows="2"
                                    data-preview="<?= esc($field) ?>"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                ><?= esc(old($field, $template[$field])) ?></textarea>
                            <?php else : ?>
                                <input
                                    id="<?= esc($field) ?>"
                                    name="<?= esc($field) ?>"
                                    type="text"
                                    maxlength="150"
                                    required
                                    value="<?= esc(old($field, $template[$field])) ?>"
                                    data-preview="<?= esc($field) ?>"
                                    class="w-full rounded-lg border border-slate-300 px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                            <?php endif; ?>
                            <?php if (isset($errors[$field])) : ?>
                                <p class="mt-1 text-sm text-red-600"><?= esc($errors[$field]) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endforeach; ?>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-slate-800">Pratinjau Teks Template</h2>
            <div class="space-y-5 rounded-lg border border-slate-200 p-5">
                <?php foreach ($previewGroups as $group => $fields) : ?>
                    <div>
                        <h3 class="mb-2 border-b border-slate-300 pb-1 text-sm font-bold"><?= esc($group) ?></h3>
                        <div class="grid gap-x-6 gap-y-1 sm:grid-cols-2">
                            <?php foreach ($fields as $field => $label) : ?>
                                <p class="text-sm">
                                    <span class="text-slate-500"><?= esc($label) ?>:</span>
                                    <span class="whitespace-pre-line" data-preview-target="<?= esc($field) ?>"><?= esc(old($field, $template[$field])) ?></span>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">
            <a href="<?= base_url('dashboard/admin') ?>" class="rounded-lg border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Batal
            </a>
            <button type="submit" class="rounded-lg bg-blue-700 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-800">
                Simpan Template
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
