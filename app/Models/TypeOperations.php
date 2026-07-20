<?php 
namespace App\Models;

use CodeIgniter\Model;

class TypeOperations extends Model{
    protected $table = 'type_operations';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nom'
    ];

}