<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLhpDocumentTemplateTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
            ],
            'template_json' => [
                'type' => 'LONGTEXT',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('lhp_document_template', true);
    }

    public function down()
    {
        $this->forge->dropTable('lhp_document_template', true);
    }
}
