<?php 
namespace App\Models;

use CodeIgniter\Model;

class Reseaux extends Model {
    protected $table = 'reseaux';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom',
        'commission_transfert'
    ];

    // Récupère la config + le réseau associé à un numéro
    public function getReseauByTelephone($telephone)
    {
        $prefixe = substr($telephone, 0, 3);

        $db = \Config\Database::connect();
        return $db->table('configurations')
                  ->select('configurations.*, reseaux.nom, reseaux.commission_transfert')
                  ->join('reseaux', 'reseaux.id = configurations.reseau_id')
                  ->where('configurations.prefixe', $prefixe)
                  ->get()
                  ->getRowArray();
    }

    // Vérifie si un numéro de téléphone appartient au réseau local (reseau_id = 1)
    public function estNumeroLocal($telephone)
    {
        $prefixe = substr($telephone, 0, 3);

        $db = \Config\Database::connect();
        $config = $db->table('configurations')
                     ->where('prefixe', $prefixe)
                     ->get()
                     ->getRowArray();

        if (!$config) {
            return false;
        }

        return (int)$config['reseau_id'] === 1;
    }

    // Récupère la commission de transfert liée au réseau du numéro
    public function getCommissionTransfert($telephone)
    {
        $reseauInfo = $this->getReseauByTelephone($telephone);

        if (!$reseauInfo) {
            return 0; // Pas de commission si non trouvé
        }

        return $reseauInfo['commission_transfert'];
    }

    public function getAllReseaux()
    {
        return $this->findAll();
    }
}