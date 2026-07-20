<?php 
namespace App\Models;

use CodeIgniter\Model;

class Operateurs extends Model{
    protected $table = 'operateurs';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom',
        'mot_de_passe'
    ];

    public function getOperateurByNom($nom){
        $builder = $this->builder();
        $builder->where('nom', $nom);
        return $builder->get()->getRow();
    }

    public function getOperateurById($id){
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->get()->getRow();
    }

    public function getOperateurByNomAndPassword($nom, $mot_de_passe){
        $builder = $this->builder();
        $builder->where('nom', $nom);
        $builder->where('mot_de_passe', $mot_de_passe);
        return $builder->get()->getRow();
    }
}