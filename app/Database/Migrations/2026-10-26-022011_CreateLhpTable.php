<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLhpTable extends Migration
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

            // Relasi dengan pengguna
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            // Identitas laporan
            'nomor_lhp' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'tahapan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'nama_pengawas' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'jabatan_pengawas' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'nomor_surat_tugas' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'tanggal_surat_tugas' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'alamat_pengawas' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            // Informasi kegiatan pengawasan
            'bentuk_pengawasan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'tujuan_pengawasan' => [
                'type' => 'TEXT',
            ],

            'sasaran_pengawasan' => [
                'type' => 'TEXT',
            ],

            'waktu_pengawasan' => [
                'type' => 'DATETIME',
            ],

            'tempat_pengawasan' => [
                'type' => 'TEXT',
            ],

            // Cakupan wilayah pengawasan
            'kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'desa' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'tps' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            // Uraian hasil pengawasan
            'uraian_hasil' => [
                'type' => 'LONGTEXT',
            ],

            // Informasi dugaan pelanggaran
            'ada_dugaan_pelanggaran' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],

            'peristiwa_pelanggaran' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'tempat_pelanggaran' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'waktu_pelanggaran' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'pelaku_pelanggaran' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'alamat_pelaku' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'saksi' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'barang_bukti' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'uraian_pelanggaran' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],

            'fakta_pelanggaran' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],

            'analisa_pelanggaran' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],

            // Informasi potensi sengketa
            'ada_potensi_sengketa' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],

            'peserta_sengketa' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'tempat_sengketa' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'waktu_sengketa' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'objek_sengketa' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'tanggal_objek_dikeluarkan' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'kerugian_langsung' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'uraian_sengketa' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],

            // Status laporan
            'status' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'draft',
                    'dikirim',
                ],
                'default' => 'draft',
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

        $this->forge->addKey('user_id');
        $this->forge->addKey('tahapan');
        $this->forge->addKey('kecamatan');
        $this->forge->addKey('waktu_pengawasan');
        $this->forge->addKey('status');

        $this->forge->addUniqueKey('nomor_lhp');

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->forge->createTable('lhp', true);
    }

    public function down()
    {
        $this->forge->dropTable('lhp', true);
    }
}
