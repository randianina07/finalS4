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

}