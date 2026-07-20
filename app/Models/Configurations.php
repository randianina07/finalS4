<?php 
namespace App\Models;

use CodeIgniter\Model;

class Configurations extends Model{
    protected $table = 'configurations';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'prefixe',
        'reseau_id'
    ];

    public function prefixeValide($telephone)
    {
        $prefixe = substr($telephone, 0, 3);
        return $this->where('prefixe', $prefixe)
                ->where('reseau_id', 1)
                ->first();
    }

}