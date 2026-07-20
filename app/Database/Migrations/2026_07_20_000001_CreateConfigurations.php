<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfigurations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'prefixe' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => false,
                'unique' => true,
            ],
            'reseau_id' => [
                'type' => 'INTEGER',
                'unsigned' => true,
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('reseau_id', 'reseaux', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('configurations');
    }

    public function down()
    {
        $this->forge->dropTable('configurations');
    }
}