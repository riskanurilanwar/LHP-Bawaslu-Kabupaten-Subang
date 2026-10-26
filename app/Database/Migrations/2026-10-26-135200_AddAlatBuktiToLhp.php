<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAlatBuktiToLhp extends Migration
{
    public function up()
    {
        $this->forge->addColumn('lhp', [
            'alat_bukti' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('lhp', 'alat_bukti');
    }
}
