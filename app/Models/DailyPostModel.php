<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyPostModel extends Model
{
    protected $table = 'daily_posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['image', 'description', 'date'];
    protected $useTimestamps = false;
}
?>