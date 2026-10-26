<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'role' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'pengawas',
                    'pimpinan',
                    'admin',
                ],
                'default' => 'pengawas',
            ],

            'jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'foto_profil' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addUniqueKey('username');
        $this->forge->addUniqueKey('email');

        $this->forge->createTable('users', true);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}