<?php
namespace App\Models;
use CodeIgniter\Model;

class PositionModel extends Model
{
    protected $table = 'positions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['display_index', 'title', 'description'];
    public $timestamps = false;
}

