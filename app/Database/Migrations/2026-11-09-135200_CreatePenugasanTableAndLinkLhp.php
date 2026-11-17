<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenugasanTableAndLinkLhp extends Migration
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
            'pengawas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'wilayah' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tahapan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
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
        $this->forge->addKey('pengawas_id');
        $this->forge->addForeignKey('pengawas_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('created_by', 'users', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('penugasan', true);

        $this->forge->addColumn('lhp', [
            'assignment_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
        $this->forge->addForeignKey(
            'assignment_id',
            'penugasan',
            'id',
            'CASCADE',
            'SET NULL',
            'lhp_assignment_id_foreign'
        );
        $this->forge->processIndexes('lhp');
    }

    public function down()
    {
        $this->forge->dropForeignKey('lhp', 'lhp_assignment_id_foreign');
        $this->forge->dropColumn('lhp', 'assignment_id');
        $this->forge->dropTable('penugasan', true);
    }
}
