<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePourcentageEpargne extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'pourcentage' => [
                'type'       => 'REAL',
                'null'       => false,
                'default'    => 0.0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('client_id', 'clients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pourcentage_epargne');
    }

    public function down()
    {
        $this->forge->dropTable('pourcentage_epargne');
    }
}