<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuRecipesTable extends Migration
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
            'menu_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'ingredient_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'jumlah_pakai' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => '1.00',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('menu_id', 'menus', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ingredient_id', 'ingredients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('menu_recipes');
    }

    public function down()
    {
        $this->forge->dropTable('menu_recipes');
    }
}
