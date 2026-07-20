<?php 
namespace App\Models;

use CodeIgniter\Model;

class BaremesFrais extends Model{
    protected $table = 'baremes_frais';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type_operation_id',
        'montant_min',
        'montant_max',
        'frais'
    ];

    public function getFrais($typeOperationId, $montant)
    {
        $row = $this->where('type_operation_id', $typeOperationId)
                    ->where('montant_min <=', $montant)
                    ->where('montant_max >=', $montant)
                    ->first();

        return $row ? (float) $row['frais'] : 0.0;
    }
}