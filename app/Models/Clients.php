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

}