<?php

namespace App\Models;

use CodeIgniter\Model;

class LhpModel extends Model
{
    protected $table            = 'lhp';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'user_id',

        // Identitas laporan
        'nomor_lhp',
        'tahapan',
        'nama_pengawas',
        'jabatan_pengawas',
        'nomor_surat_tugas',
        'tanggal_surat_tugas',
        'alamat_pengawas',

        // Kegiatan pengawasan
        'bentuk_pengawasan',
        'tujuan_pengawasan',
        'sasaran_pengawasan',
        'waktu_pengawasan',
        'tempat_pengawasan',

        // Wilayah pengawasan
        'kecamatan',
        'desa',
        'tps',

        // Hasil pengawasan
        'uraian_hasil',

        // Dugaan pelanggaran
        'ada_dugaan_pelanggaran',
        'peristiwa_pelanggaran',
        'tempat_pelanggaran',
        'waktu_pelanggaran',
        'pelaku_pelanggaran',
        'alamat_pelaku',
        'saksi',
        'alat_bukti',
        'barang_bukti',
        'uraian_pelanggaran',
        'fakta_pelanggaran',
        'analisa_pelanggaran',

        // Potensi sengketa
        'ada_potensi_sengketa',
        'bentuk_objek_sengketa',
        'peserta_sengketa',
        'tempat_sengketa',
        'waktu_sengketa',
        'objek_sengketa',
        'tanggal_objek_dikeluarkan',
        'kerugian_langsung',
        'uraian_sengketa',

        // Status laporan
        'status_pemeriksaan',
        'catatan_pimpinan',
        'diperiksa_oleh',
        'diperiksa_pada',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil LHP berdasarkan pengguna.
     *
     * Digunakan untuk menampilkan laporan
     * milik Pengawas yang sedang login.
     */
    public function getByUser(int $userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Mengambil detail LHP milik pengguna.
     */
    public function getByIdAndUser(
        int $lhpId,
        int $userId
    ) {
        return $this->where('id', $lhpId)
                    ->where('user_id', $userId)
                    ->first();
    }

    /**
     * Mengambil seluruh LHP.
     *
     * Digunakan untuk kebutuhan Admin
     * dan Pimpinan.
     */
    public function getAllLhp()
    {
        return $this->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Mengambil LHP berdasarkan status.
     */
    public function getByStatus(string $status)
    {
        return $this->where('status', $status)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Menghitung jumlah LHP berdasarkan pengguna.
     */
    public function countByUser(int $userId)
    {
        return $this->where('user_id', $userId)
                    ->countAllResults();
    }

    /**
     * Menghitung jumlah LHP berdasarkan status.
     */
    public function countByStatus(string $status)
    {
        return $this->where('status', $status)
                    ->countAllResults();
    }

    /**
     * Menghitung seluruh LHP.
     */
    public function countAllLhp()
    {
        return $this->countAllResults();
    }

    /**
     * Mengambil LHP berdasarkan rentang tanggal.
     *
     * Digunakan untuk rekapitulasi.
     */
    public function getByDateRange(
        string $tanggalAwal,
        string $tanggalAkhir
    ) {
        return $this->where(
            'waktu_pengawasan >=',
            $tanggalAwal
        )
        ->where(
            'waktu_pengawasan <=',
            $tanggalAkhir
        )
        ->orderBy('waktu_pengawasan', 'DESC')
        ->findAll();
    }

    /**
     * Mengambil LHP berdasarkan kecamatan.
     */
    public function getByKecamatan(string $kecamatan)
    {
        return $this->where('kecamatan', $kecamatan)
                    ->orderBy('waktu_pengawasan', 'DESC')
                    ->findAll();
    }

    /**
     * Mengambil LHP berdasarkan tahapan.
     */
    public function getByTahapan(string $tahapan)
    {
        return $this->where('tahapan', $tahapan)
                    ->orderBy('waktu_pengawasan', 'DESC')
                    ->findAll();
    }
}
