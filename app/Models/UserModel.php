<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'nama',
        'username',
        'email',
        'password',
        'role',
        'jabatan',
        'no_hp',
        'foto_profil',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil pengguna berdasarkan username.
     */
    public function getByUsername(string $username)
    {
        return $this->where('username', $username)
                    ->first();
    }

    /**
     * Mengambil pengguna berdasarkan email.
     */
    public function getByEmail(string $email)
    {
        return $this->where('email', $email)
                    ->first();
    }

    /**
     * Mengambil pengguna berdasarkan role.
     */
    public function getByRole(string $role)
    {
        return $this->where('role', $role)
                    ->where('is_active', 1)
                    ->findAll();
    }

    /**
     * Mengambil seluruh pengguna aktif.
     */
    public function getActiveUsers()
    {
        return $this->where('is_active', 1)
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    /**
     * Mengambil data profil pengguna.
     */
    public function getProfile(int $id)
    {
        return $this->select(
            'id, nama, username, email, role, jabatan, no_hp, foto_profil'
        )
        ->find($id);
    }
}
