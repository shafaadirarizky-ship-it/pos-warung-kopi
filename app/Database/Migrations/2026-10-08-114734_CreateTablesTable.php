<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablesTable extends Migration
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
            'nomor_meja' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'kapasitas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 4,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['tersedia', 'terisi', 'reservasi'],
                'default'    => 'tersedia',
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
        $this->forge->createTable('tables');
    }

    public function down()
    {
        $this->forge->dropTable('tables');
    }
}
