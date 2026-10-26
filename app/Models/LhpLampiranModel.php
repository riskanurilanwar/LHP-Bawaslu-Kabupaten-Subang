<?php

namespace App\Models;

use CodeIgniter\Model;

class LhpLampiranModel extends Model
{
    protected $table            = 'lhp_lampiran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'lhp_id',
        'nama_file',
        'nama_asli',
        'path_file',
        'tipe_file',
        'ukuran_file',
        'keterangan',
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil seluruh lampiran berdasarkan LHP.
     */
    public function getByLhp(int $lhpId)
    {
        return $this->where('lhp_id', $lhpId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Mengambil detail lampiran.
     */
    public function getById(int $id)
    {
        return $this->find($id);
    }

    /**
     * Menghapus seluruh lampiran berdasarkan LHP.
     */
    public function deleteByLhp(int $lhpId)
    {
        return $this->where('lhp_id', $lhpId)
                    ->delete();
    }

    /**
     * Menghitung jumlah lampiran pada LHP.
     */
    public function countByLhp(int $lhpId)
    {
        return $this->where('lhp_id', $lhpId)
                    ->countAllResults();
    }
}
