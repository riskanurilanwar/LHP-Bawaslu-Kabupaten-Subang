<?php

namespace App\Models;

use CodeIgniter\Model;

class PenugasanModel extends Model
{
    protected $table            = 'penugasan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'pengawas_id',
        'wilayah',
        'tahapan',
        'created_by',
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
