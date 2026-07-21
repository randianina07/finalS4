<?php 
namespace App\Models;

use CodeIgniter\Model;

class PourcentageEpargne extends Model{
    protected $table = 'pourcentage_epargne';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'client_id',
        'pourcentage'
    ];


    public function createPourcentage ($client_id, $pourcentage)
    {
        $data = [
            'client_id' => $client_id,
            'pourcentage' => $pourcentage
        ];

        $this->insert($data);

        return $this->find($this->getInsertID());
    }

    public function getPcEpargneByClient ($client_id)
    {
        $builder = $this->builder();
        $builder->where('client_id', $client_id);
        return $builder->get()->getRow();
    }
}