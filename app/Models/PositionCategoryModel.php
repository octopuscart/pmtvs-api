<?php
namespace App\Models;
use CodeIgniter\Model;

class PositionCategoryModel extends Model
{
    protected $table = 'position_category';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'display_index'];
    public $timestamps = false;
}

