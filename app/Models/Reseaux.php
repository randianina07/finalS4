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

    public function getReseauByTelephone($telephone)
    {
        $prefixe = substr($telephone, 0, 3);

        return $this->select('configurations.*, reseaux.nom, reseaux.commission_transfert')
                    ->join('reseaux', 'reseaux.id = configurations.reseau_id')
                    ->where('configurations.prefixe', $prefixe)
                    ->first();
    }
}