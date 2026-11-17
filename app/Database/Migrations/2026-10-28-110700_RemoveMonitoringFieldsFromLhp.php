<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveMonitoringFieldsFromLhp extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('lhp', [
            'status_pemeriksaan',
            'catatan_pimpinan',
            'diperiksa_oleh',
            'diperiksa_pada',
        ]);
    }

    public function down()
    {
        $this->forge->addColumn('lhp', [
            'status_pemeriksaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'Menunggu Pemeriksaan',
                'after'      => 'id',
            ],
            'catatan_pimpinan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'diperiksa_oleh' => [
                'type' => 'INT',
                'null' => true,
            ],
            'diperiksa_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }
}
