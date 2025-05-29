<?php
namespace App\Models;
use CodeIgniter\Model;

class PositionsModel extends Model
{
    protected $table = 'positions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'display_index', 'category_id'];
    public $timestamps = false;
}