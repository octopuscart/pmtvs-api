<?php
namespace App\Models;
use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table      = 'members';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'position_id', 'position_category_id', 'address', 'image'];
    protected $useTimestamps = false;
}