<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBentukObjekSengketaToLhp extends Migration
{
    public function up()
    {
        $this->forge->addColumn('lhp', [
            'bentuk_objek_sengketa' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('lhp', 'bentuk_objek_sengketa');
    }
}
