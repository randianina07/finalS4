<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReseaux extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'commission_transfert' => [
                'type'       => 'REAL',
                'null'       => false,
                'default'    => 0.0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('reseaux');
    }

    public function down()
    {
        $this->forge->dropTable('reseaux');
    }
}