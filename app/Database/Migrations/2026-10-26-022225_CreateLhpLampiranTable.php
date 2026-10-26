<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLhpLampiranTable extends Migration
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

            'lhp_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'nama_asli' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'tipe_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'ukuran_file' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'null'       => true,
            ],

            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey('lhp_id');

        $this->forge->addForeignKey(
            'lhp_id',
            'lhp',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('lhp_lampiran', true);
    }

    public function down()
    {
        $this->forge->dropTable('lhp_lampiran', true);
    }
}
