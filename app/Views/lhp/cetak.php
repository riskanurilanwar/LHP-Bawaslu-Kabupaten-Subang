<?php
$template = array_replace(
    \App\Models\LhpDocumentTemplateModel::DEFAULT_TEMPLATE,
    $template ?? []
);

$tanggal = static function ($value, bool $withTime = false) use ($template): string {
    if ($value === null || $value === '') {
        return $template['empty_value'];
    }

    $timestamp = strtotime((string) $value);

    return $timestamp === false
        ? (string) $value
        : date($withTime ? 'd-m-Y H:i' : 'd-m-Y', $timestamp);
};

$isi = static function ($value) use ($template): string {
    return $value === null || $value === ''
        ? esc($template['empty_value'])
        : nl2br(esc((string) $value));
};

$saksi = json_decode((string) ($lhp['saksi'] ?? ''), true);
if (! is_array($saksi)) {
    $saksi = [];
}

$adaPelanggaran = (int) ($lhp['ada_dugaan_pelanggaran'] ?? 0) === 1;
$adaSengketa = (int) ($lhp['ada_potensi_sengketa'] ?? 0) === 1;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($template['document_title']) ?> <?= esc($lhp['nomor_lhp'] ?: ('#' . $lhp['id'])) ?></title>
    <style>
        @page {
            size: A4;
            margin: 14mm 17mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #111;
            font-family: "Times New Roman", Times, serif;
            font-size: 10.5pt;
            line-height: 1.35;
        }

        .toolbar {
            display: flex;
            gap: 10px;
            margin: 0 auto 18px;
            max-width: 210mm;
        }

        .toolbar a,
        .toolbar button {
            border: 0;
            border-radius: 5px;
            background: #1d4ed8;
            color: #fff;
            cursor: pointer;
            font-size: 10pt;
            padding: 10px 14px;
            text-decoration: none;
        }

        .toolbar a {
            background: #475569;
        }

        .letterhead {
            border-bottom: 3px double #111;
            margin-bottom: 12px;
            padding-bottom: 8px;
        }

        .letterhead-brand {
            align-items: center;
            display: flex;
            gap: 10px;
        }

        .letterhead-mark {
            flex: 0 0 29mm;
            height: 33.5mm;
            overflow: hidden;
            position: relative;
            width: 29mm;
        }

        .letterhead-mark img {
            left: 0;
            max-width: none;
            position: absolute;
            top: 0;
            width: 140mm;
        }

        .letterhead-copy h1,
        .letterhead-copy h2,
        .letterhead-copy p {
            margin: 1px 0;
        }

        .letterhead-copy h1 {
            font-size: 13pt;
            letter-spacing: .02em;
        }

        .letterhead-copy h2 {
            font-size: 12pt;
        }

        .letterhead-contact {
            font-size: 9pt;
        }

        .regulation-heading {
            font-size: 9pt;
            line-height: 1.2;
            margin: 0 auto 8px;
            max-width: 125mm;
            text-align: center;
            text-transform: uppercase;
        }

        .document-title {
            margin: 0;
            text-align: center;
            text-decoration: underline;
            font-size: 12pt;
        }

        .document-number {
            margin: 3px 0 12px;
            text-align: center;
        }

        .section {
            margin-top: 11px;
        }

        .section h3 {
            break-after: avoid;
            font-size: 10.5pt;
            margin: 0 0 3px;
        }

        table.details {
            border-collapse: collapse;
            width: 100%;
        }

        table.details td {
            padding: 2px 3px;
            vertical-align: top;
        }

        table.details td.label {
            width: 35%;
        }

        table.details td.separator {
            width: 5mm;
            text-align: center;
        }

        table.details tr {
            break-inside: avoid;
        }

        table.details td:last-child {
            border-bottom: 1px dotted #555;
        }

        .narrative {
            background-image: repeating-linear-gradient(
                to bottom,
                transparent 0,
                transparent calc(1.35em - 1px),
                #aaa calc(1.35em - 1px),
                #aaa 1.35em
            );
            min-height: 36mm;
            padding: 2px 4px;
            white-space: normal;
        }

        .witness-table,
        .witness-table th,
        .witness-table td {
            border: 1px solid #64748b;
            border-collapse: collapse;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        .witness-table {
            width: 100%;
        }

        .signature {
            break-inside: avoid;
            margin: 24px 0 0 auto;
            text-align: center;
            width: 250px;
        }

        .signature .space {
            height: 55px;
        }

        .attachment-list {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, 1fr);
        }

        .attachment {
            margin: 0;
            page-break-inside: avoid;
            text-align: center;
        }

        .attachment img {
            max-height: 105mm;
            max-width: 100%;
            object-fit: contain;
        }

        .attachment figcaption {
            font-size: 9pt;
            margin-top: 4px;
        }

        @media print {
            .toolbar {
                display: none;
            }

            .signature,
            .attachment {
                break-inside: avoid;
            }
        }

        @media screen {
            body {
                margin: 24px auto;
                max-width: 210mm;
                padding: 0 18px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
        <a href="<?= base_url('lhp/detail/' . $lhp['id']) ?>">Kembali ke Detail</a>
    </div>

    <header class="letterhead">
        <div class="letterhead-brand">
            <div class="letterhead-mark">
                <img src="<?= base_url('assets/images/kop-bawaslu-subang.png') ?>" alt="Lambang Bawaslu">
            </div>
            <div class="letterhead-copy">
                <h1><?= esc($template['organization_name']) ?></h1>
                <h2><?= esc($template['organization_region']) ?></h2>
                <p class="letterhead-contact"><?= esc($template['organization_address']) ?></p>
                <p class="letterhead-contact">
                    <?= esc($template['contact_phone_prefix']) ?> <?= esc($template['organization_phone']) ?> |
                    <?= esc($template['contact_email_prefix']) ?> <?= esc($template['organization_email']) ?>
                </p>
            </div>
        </div>
    </header>

    <div class="regulation-heading">
        <?= esc($template['regulation_attachment']) ?><br>
        <?= esc($template['regulation_name']) ?><br>
        <?= esc($template['regulation_number']) ?> <?= esc($template['regulation_subject']) ?><br>
        <?= esc($template['form_model']) ?>
    </div>

    <h2 class="document-title"><?= esc($template['document_title']) ?></h2>
    <p class="document-number">
        <?= esc($template['number_label']) ?> <?= esc($lhp['nomor_lhp'] ?: $template['empty_value']) ?>
    </p>

    <section class="section">
        <h3><?= esc($template['section_identity']) ?></h3>
        <table class="details">
            <tr><td class="label"><?= esc($template['label_stage']) ?></td><td class="separator">:</td><td><?= $isi($lhp['tahapan'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_supervisor']) ?></td><td class="separator">:</td><td><?= $isi($lhp['nama_pengawas'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_position']) ?></td><td class="separator">:</td><td><?= $isi($lhp['jabatan_pengawas'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_task_order_number']) ?></td><td class="separator">:</td><td><?= $isi($lhp['nomor_surat_tugas'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_task_order_date']) ?></td><td class="separator">:</td><td><?= esc($tanggal($lhp['tanggal_surat_tugas'] ?? null)) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_address']) ?></td><td class="separator">:</td><td><?= $isi($lhp['alamat_pengawas'] ?? null) ?></td></tr>
        </table>
    </section>

    <section class="section">
        <h3><?= esc($template['section_activity']) ?></h3>
        <table class="details">
            <tr><td class="label"><?= esc($template['label_activity_form']) ?></td><td class="separator">:</td><td><?= $isi($lhp['bentuk_pengawasan'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_activity_purpose']) ?></td><td class="separator">:</td><td><?= $isi($lhp['tujuan_pengawasan'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_activity_target']) ?></td><td class="separator">:</td><td><?= $isi($lhp['sasaran_pengawasan'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_activity_time']) ?></td><td class="separator">:</td><td><?= esc($tanggal($lhp['waktu_pengawasan'] ?? null, true)) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_activity_place']) ?></td><td class="separator">:</td><td><?= $isi($lhp['tempat_pengawasan'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_district']) ?></td><td class="separator">:</td><td><?= $isi($lhp['kecamatan'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_village']) ?></td><td class="separator">:</td><td><?= $isi($lhp['desa'] ?? null) ?></td></tr>
            <tr><td class="label"><?= esc($template['label_polling_station']) ?></td><td class="separator">:</td><td><?= $isi($lhp['tps'] ?? null) ?></td></tr>
        </table>
    </section>

    <section class="section">
        <h3><?= esc($template['section_results']) ?></h3>
        <div class="narrative"><?= $isi($lhp['uraian_hasil'] ?? null) ?></div>
    </section>

    <section class="section">
        <h3><?= esc($template['section_violation']) ?></h3>
        <table class="details">
            <tr><td class="label"><?= esc($template['label_violation_yes_no']) ?></td><td class="separator">:</td><td><?= esc($adaPelanggaran ? $template['answer_yes'] : $template['answer_no']) ?></td></tr>
        </table>
        <?php if ($adaPelanggaran): ?>
            <table class="details">
                <tr><td class="label"><?= esc($template['label_violation_event']) ?></td><td class="separator">:</td><td><?= $isi($lhp['peristiwa_pelanggaran'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_violation_place']) ?></td><td class="separator">:</td><td><?= $isi($lhp['tempat_pelanggaran'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_violation_time']) ?></td><td class="separator">:</td><td><?= esc($tanggal($lhp['waktu_pelanggaran'] ?? null, true)) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_violation_actor']) ?></td><td class="separator">:</td><td><?= $isi($lhp['pelaku_pelanggaran'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_actor_address']) ?></td><td class="separator">:</td><td><?= $isi($lhp['alamat_pelaku'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_evidence_tool']) ?></td><td class="separator">:</td><td><?= $isi($lhp['alat_bukti'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_evidence_item']) ?></td><td class="separator">:</td><td><?= $isi($lhp['barang_bukti'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_violation_description']) ?></td><td class="separator">:</td><td><?= $isi($lhp['uraian_pelanggaran'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_violation_facts']) ?></td><td class="separator">:</td><td><?= $isi($lhp['fakta_pelanggaran'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_violation_analysis']) ?></td><td class="separator">:</td><td><?= $isi($lhp['analisa_pelanggaran'] ?? null) ?></td></tr>
            </table>

            <p><strong><?= esc($template['witness_heading']) ?></strong></p>
            <table class="witness-table">
                <thead><tr><th style="width: 40px"><?= esc($template['table_number']) ?></th><th><?= esc($template['table_witness_name']) ?></th><th><?= esc($template['table_witness_address']) ?></th></tr></thead>
                <tbody>
                    <?php $saksiTerisi = array_values(array_filter($saksi, static fn ($item): bool => ! empty($item['nama']) || ! empty($item['alamat']))); ?>
                    <?php if ($saksiTerisi === []): ?>
                        <tr><td colspan="3"><?= esc($template['empty_value']) ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($saksiTerisi as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $isi($item['nama'] ?? null) ?></td>
                                <td><?= $isi($item['alamat'] ?? null) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <section class="section">
        <h3><?= esc($template['section_dispute']) ?></h3>
        <table class="details">
            <tr><td class="label"><?= esc($template['label_dispute_yes_no']) ?></td><td class="separator">:</td><td><?= esc($adaSengketa ? $template['answer_yes'] : $template['answer_no']) ?></td></tr>
        </table>
        <?php if ($adaSengketa): ?>
            <table class="details">
                <tr><td class="label"><?= esc($template['label_dispute_participant']) ?></td><td class="separator">:</td><td><?= $isi($lhp['peserta_sengketa'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_dispute_place']) ?></td><td class="separator">:</td><td><?= $isi($lhp['tempat_sengketa'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_dispute_time']) ?></td><td class="separator">:</td><td><?= esc($tanggal($lhp['waktu_sengketa'] ?? null, true)) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_dispute_object_type']) ?></td><td class="separator">:</td><td><?= $isi($lhp['bentuk_objek_sengketa'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_dispute_object_identity']) ?></td><td class="separator">:</td><td><?= $isi($lhp['objek_sengketa'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_dispute_object_date']) ?></td><td class="separator">:</td><td><?= esc($tanggal($lhp['tanggal_objek_dikeluarkan'] ?? null)) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_dispute_loss']) ?></td><td class="separator">:</td><td><?= $isi($lhp['kerugian_langsung'] ?? null) ?></td></tr>
                <tr><td class="label"><?= esc($template['label_dispute_description']) ?></td><td class="separator">:</td><td><?= $isi($lhp['uraian_sengketa'] ?? null) ?></td></tr>
            </table>
        <?php endif; ?>
    </section>

    <div class="signature">
        <?= esc($template['signature_city']) ?><?= esc($template['signature_date_separator']) ?> <?= esc(date('d-m-Y')) ?><br>
        <?= esc($template['signature_title']) ?>
        <div class="space"></div>
        <strong><u><?= esc($lhp['nama_pengawas'] ?? '') ?></u></strong><br>
        <?= esc($lhp['jabatan_pengawas'] ?? '') ?>
    </div>

    <?php if ($lampiran !== []): ?>
        <section class="section">
            <h3><?= esc($template['attachment_heading']) ?></h3>
            <div class="attachment-list">
                <?php foreach ($lampiran as $file): ?>
                    <figure class="attachment">
                        <img
                            src="<?= esc(base_url('lhp/lampiran/' . $file['id'])) ?>"
                            alt="<?= esc($file['nama_asli'] ?? $template['attachment_alt']) ?>"
                        >
                        <figcaption><?= esc($file['nama_asli'] ?? $template['attachment_alt']) ?></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</body>
</html>
