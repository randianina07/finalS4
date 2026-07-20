<?php 
namespace App\Models;

use CodeIgniter\Model;

class Configurations extends Model{
    protected $table = 'configurations';

    protected $primaryKey = 'id';
    protected $allowedFields = [
        'prefixe'
    ];

}