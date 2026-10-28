<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'nama'      => 'Admin Bawaslu',
                'username'  => 'admin',
                'email'     => 'admin@example.com',
                'password'  => password_hash(
                    'Admin123!',
                    PASSWORD_DEFAULT
                ),
                'role'      => 'admin',
                'jabatan'   => 'Administrator',
                'is_active' => 1,
            ],

            [
                'nama'      => 'Pimpinan Bawaslu',
                'username'  => 'pimpinan',
                'email'     => 'pimpinan@example.com',
                'password'  => password_hash(
                    'Pimpinan123!',
                    PASSWORD_DEFAULT
                ),
                'role'      => 'pimpinan',
                'jabatan'   => 'Pimpinan',
                'is_active' => 1,
            ],

            [
                'nama'      => 'Pengawas Bawaslu',
                'username'  => 'pengawas',
                'email'     => 'pengawas@example.com',
                'password'  => password_hash(
                    'Pengawas123!',
                    PASSWORD_DEFAULT
                ),
                'role'      => 'pengawas',
                'jabatan'   => 'Pengawas',
                'is_active' => 1,
            ],
        ];

        foreach ($users as $user) {

            $existingUser = $this->db
                ->table('users')
                ->where('username', $user['username'])
                ->get()
                ->getRowArray();

            if (!$existingUser) {

                $this->db
                    ->table('users')
                    ->insert($user);

            }
        }
    }
}
