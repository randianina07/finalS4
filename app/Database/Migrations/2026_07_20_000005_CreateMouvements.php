<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMouvements extends Migration
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

            'client_source_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],

            'client_destination_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],

            'montant_brut' => [
                'type' => 'REAL',
            ],

            'frais' => [
                'type' => 'REAL',
            ],

            'date_creation' => [
                'type'    => 'DATETIME',
                'default' => 'CURRENT_TIMESTAMP',
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

        $this->forge->addForeignKey(
            'client_source_id',
            'clients',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'client_destination_id',
            'clients',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('mouvements');
    }

    public function down()
    {
        $this->forge->dropTable('mouvements');
    }
}