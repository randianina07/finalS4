<?php 
namespace App\Models;

use CodeIgniter\Model;

class Reseaux extends Model{
    protected $table = 'reseaux';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom',
        'commission_transfert'
    ];

    // Récupère le réseau associé à un numéro de téléphone donné
    public function getReseauByTelephone($telephone)
    {
        $prefixe = substr($telephone, 0, 3);

        return $this->select('configurations.*, reseaux.nom, reseaux.commission_transfert')
                    ->join('reseaux', 'reseaux.id = configurations.reseau_id')
                    ->where('configurations.prefixe', $prefixe)
                    ->first();
    }

    // Vérifie si un numéro de téléphone appartient au réseau local (reseau_id = 1)
    public function estNumeroLocal($telephone)
    {
        $prefixe = substr($telephone, 0, 3);

        $config = $this->where('prefixe', $prefixe)
                    ->first();

        if (!$config) {
            return false;
        }

        return $config['reseau_id'] == 1;
    }

    public function getCommissionTransfert($telephone)
    {
        $prefixe = substr($telephone, 0, 3);

        $config = $this->where('prefixe', $prefixe)
                    ->first();

        if (!$config) {
            return null; // ou une valeur par défaut
        }

        return $config['commission_transfert'];
    }

    public function getAllReseaux()
    {
        return $this->findAll();
    }
  
}