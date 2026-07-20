<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBaremesFrais extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type_operation_id' => [
                'type' => 'INTEGER',
                'unsigned' => true,
            ],
            'montant_min' => [
                'type' => 'REAL',
            ],
            'montant_max' => [
                'type' => 'REAL',
            ],
            'frais' => [
                'type' => 'REAL',
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey(
            'type_operation_id',
            'type_operations',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('baremes_frais');
    }

    public function down()
    {
        $this->forge->dropTable('baremes_frais');
    }
}