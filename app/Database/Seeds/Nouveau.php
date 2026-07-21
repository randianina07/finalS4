<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Nouveau extends Seeder
{
    public function run()
    {
        /*
        * RESEAUX
        */
        $this->db->table('reseaux')->insertBatch([
            [
                'nom' => 'MonOperateur',
                'commission_transfert' => 50
            ],
            [
                'nom' => 'Airtel',
                'commission_transfert' => 20
            ],
            [
                'nom' => 'Orange',
                'commission_transfert' => 15
            ],
        ]);
    }
}