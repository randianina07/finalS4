<?php 
namespace App\Models;

use CodeIgniter\Model;

class Mouvements extends Model{
    protected $table = 'mouvements';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type_operation_id',
        'client_source_id',
        'client_destination_id',
        'montant_brut',
        'frais',
        'date_creation'
    ];

}