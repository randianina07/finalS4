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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('configurations');
    }

    public function down()
    {
        $this->forge->dropTable('configurations');
    }
}