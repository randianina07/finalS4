<?php 
namespace App\Models;

use CodeIgniter\Model;

class Clients extends Model{
    protected $table = 'clients';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'numero_telephone',
        'solde'
    ];

    public function getClientByNumeroTelephone($numero_telephone){
        $builder = $this->builder();
        $builder->where('numero_telephone', $numero_telephone);
        return $builder->get()->getRow();
    }

    public function getClientById($id){
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function createClient($numero_telephone)
    {
        $data = [
            'numero_telephone' => $numero_telephone,
            'solde' => 0
        ];

        $this->insert($data);

        return $this->find($this->getInsertID());
    }
}