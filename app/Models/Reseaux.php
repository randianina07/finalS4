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
}