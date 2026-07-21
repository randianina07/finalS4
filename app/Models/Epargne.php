<?php 
namespace App\Models;

use CodeIgniter\Model;

class Epargne extends Model{
    protected $table = 'epargne';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_id',
        'montant'
    ];

    public function createEpargne ($client_id, $epargne)
    {
        $data = [
            'client_id' => $client_id,
            'pourcentage' => $epargne
        ];

        $this->insert($data);

        return $this->find($this->getInsertID());
    }

}