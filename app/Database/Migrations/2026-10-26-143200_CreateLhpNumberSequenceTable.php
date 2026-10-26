<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLhpNumberSequenceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tahun' => [
                'type'       => 'SMALLINT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'nomor_terakhir' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('tahun', true);
        $this->forge->createTable('lhp_nomor_sequence', true);
    }

    public function down()
    {
        $this->forge->dropTable('lhp_nomor_sequence', true);
    }
}
