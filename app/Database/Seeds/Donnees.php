<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Donnees extends Seeder
{
    public function run()
    {
        /*
        * RESEAUX
        */
        $this->db->table('reseaux')->insertBatch([
            [
                'nom' => 'MonOperateur',
                'commission_transfert' => 0
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


        $reseaux = $this->db->table('reseaux')
            ->get()
            ->getResultArray();

        $idsReseaux = [];

        foreach ($reseaux as $reseau) {
            $idsReseaux[$reseau['nom']] = $reseau['id'];
        }

        /*
        * PREFIXES
        */
        $this->db->table('configurations')->insertBatch([

            // Mon opérateur
            [
                'prefixe' => '033',
                'reseau_id' => $idsReseaux['MonOperateur']
            ],
            [
                'prefixe' => '037',
                'reseau_id' => $idsReseaux['MonOperateur']
            ],

            // Airtel
            [
                'prefixe' => '032',
                'reseau_id' => $idsReseaux['Airtel']
            ],

            // Orange
            [
                'prefixe' => '034',
                'reseau_id' => $idsReseaux['Orange']
            ],
        ]);

        /*
         * TYPES OPERATIONS
         */
        $this->db->table('type_operations')->insertBatch([
            ['nom' => 'depot'],
            ['nom' => 'retrait'],
            ['nom' => 'transfert'],
        ]);

        /*
         * CLIENTS DE TEST
         */
        $this->db->table('clients')->insertBatch([
            [
                'numero_telephone' => '0331234567',
                'solde' => 100000
            ],
            [
                'numero_telephone' => '0379876543',
                'solde' => 50000
            ],
            [
                'numero_telephone' => '0335555555',
                'solde' => 250000
            ],

            // Réseaux externes
            [
                'numero_telephone' => '0321111111',
                'solde' => 70000
            ],
            [
                'numero_telephone' => '0342222222',
                'solde' => 90000
            ],
        ]);

        /*
         * BAREMES FRAIS
         */

        // Récupération des ids
        $types = $this->db->table('type_operations')
            ->get()
            ->getResultArray();

        $ids = [];
        foreach ($types as $type) {
            $ids[$type['nom']] = $type['id'];
        }

        $this->db->table('baremes_frais')->insertBatch([

            // RETRAIT
            [
                'type_operation_id' => $ids['retrait'],
                'montant_min' => 0,
                'montant_max' => 50000,
                'frais' => 500
            ],
            [
                'type_operation_id' => $ids['retrait'],
                'montant_min' => 50001,
                'montant_max' => 100000,
                'frais' => 1000
            ],

            // TRANSFERT
            [
                'type_operation_id' => $ids['transfert'],
                'montant_min' => 0,
                'montant_max' => 50000,
                'frais' => 200
            ],
            [
                'type_operation_id' => $ids['transfert'],
                'montant_min' => 50001,
                'montant_max' => 100000,
                'frais' => 500
            ],

            // DEPOT
            [
                'type_operation_id' => $ids['depot'],
                'montant_min' => 0,
                'montant_max' => 999999999,
                'frais' => 0
            ],
        ]);

        /*
         * OPERATEURS DE TEST
         */
        $this->db->table('operateurs')->insertBatch([
            [
                'nom' => 'Operateur1',
                'mot_de_passe' => 'password1'
            ],
            [
                'nom' => 'Operateur2',
                'mot_de_passe' => 'password2'
            ],
        ]);
    }
}