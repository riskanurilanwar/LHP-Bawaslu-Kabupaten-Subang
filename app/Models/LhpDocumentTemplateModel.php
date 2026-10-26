<?php

namespace App\Models;

use CodeIgniter\Model;
use UnexpectedValueException;

class LhpDocumentTemplateModel extends Model
{
    public const DEFAULT_TEMPLATE = [
        'organization_name'  => 'BADAN PENGAWAS PEMILIHAN UMUM',
        'organization_region' => 'KABUPATEN SUBANG',
        'organization_address' => 'Jl. Palabuan No. 9 Kel. Sukamelang Kec. Subang',
        'organization_phone' => '(0260) 42423530',
        'organization_email' => 'set.subangkab@bawaslu.go.id',
        'contact_phone_prefix' => 'Telp.',
        'contact_email_prefix' => 'Email:',
        'regulation_attachment' => 'Lampiran',
        'regulation_name' => 'Peraturan Badan Pengawas Pemilihan Umum Republik Indonesia',
        'regulation_number' => 'Nomor 5 Tahun 2022',
        'regulation_subject' => 'tentang Pengawasan Penyelenggaraan Pemilihan Umum',
        'form_model' => 'Formulir Model A',
        'document_title'     => 'LAPORAN HASIL PENGAWASAN PEMILU',
        'number_label'       => 'NOMOR:',
        'empty_value'        => '-',
        'section_identity'   => 'I. Data Pengawas Pemilihan',
        'section_activity'   => 'II. Kegiatan dan Wilayah Pengawasan',
        'section_results'    => 'III. Uraian Singkat Hasil Pengawasan',
        'section_violation'  => 'IV. Informasi Dugaan Pelanggaran',
        'section_dispute'    => 'V. Informasi Potensi Sengketa',
        'label_stage'        => 'Tahapan yang diawasi',
        'label_supervisor'   => 'Nama pelaksana tugas pengawasan',
        'label_position'     => 'Jabatan',
        'label_task_order_number' => 'Nomor surat perintah tugas',
        'label_task_order_date' => 'Tanggal surat tugas',
        'label_address'      => 'Alamat',
        'label_activity_form' => 'Bentuk pengawasan',
        'label_activity_purpose' => 'Tujuan pengawasan',
        'label_activity_target' => 'Sasaran pengawasan',
        'label_activity_time' => 'Waktu pengawasan',
        'label_activity_place' => 'Tempat pengawasan',
        'label_district'     => 'Kecamatan',
        'label_village'      => 'Desa / Kelurahan',
        'label_polling_station' => 'TPS',
        'label_violation_yes_no' => 'Terdapat dugaan pelanggaran',
        'answer_yes'         => 'Ya',
        'answer_no'          => 'Tidak',
        'label_violation_event' => 'Peristiwa',
        'label_violation_place' => 'Tempat kejadian',
        'label_violation_time' => 'Waktu kejadian',
        'label_violation_actor' => 'Pelaku',
        'label_actor_address' => 'Alamat pelaku',
        'label_evidence_tool' => 'Alat bukti',
        'label_evidence_item' => 'Barang bukti',
        'label_violation_description' => 'Uraian dugaan pelanggaran',
        'label_violation_facts' => 'Fakta dan keterangan',
        'label_violation_analysis' => 'Analisa',
        'witness_heading'   => 'Saksi-saksi',
        'table_number'      => 'No.',
        'table_witness_name' => 'Nama',
        'table_witness_address' => 'Alamat',
        'label_dispute_yes_no' => 'Terdapat potensi sengketa',
        'label_dispute_participant' => 'Peserta pemilu',
        'label_dispute_place' => 'Tempat kejadian',
        'label_dispute_time' => 'Waktu kejadian',
        'label_dispute_object_type' => 'Bentuk objek sengketa',
        'label_dispute_object_identity' => 'Identitas objek sengketa',
        'label_dispute_object_date' => 'Hari/tanggal objek dikeluarkan',
        'label_dispute_loss' => 'Kerugian langsung',
        'label_dispute_description' => 'Uraian singkat potensi sengketa',
        'signature_date_separator' => ',',
        'signature_city'     => 'Subang',
        'signature_title'    => 'Pengawas Pemilihan,',
        'attachment_heading' => 'Lampiran Foto Bukti Pengawasan',
        'attachment_alt'     => 'Foto bukti pengawasan',
    ];

    protected $table            = 'lhp_document_template';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['template_json', 'updated_at'];
    protected $useTimestamps   = false;

    public function getTemplate(): array
    {
        $record = $this->find(1);
        if ($record === null) {
            return self::DEFAULT_TEMPLATE;
        }

        $template = json_decode(
            $record['template_json'],
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if (! is_array($template)) {
            throw new UnexpectedValueException('Data template LHP tidak valid.');
        }

        return array_replace(self::DEFAULT_TEMPLATE, array_intersect_key(
            $template,
            self::DEFAULT_TEMPLATE
        ));
    }

    public function saveTemplate(array $template): bool
    {
        $data = [
            'template_json' => json_encode(
                $template,
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            ),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->find(1) === null) {
            return (bool) $this->insert(['id' => 1] + $data);
        }

        return $this->update(1, $data);
    }
}
