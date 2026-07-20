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

}