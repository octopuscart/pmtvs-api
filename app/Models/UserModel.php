<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'members';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'position', 'address', 'image'];
    protected $useTimestamps = false;
}