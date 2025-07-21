<?php
namespace App\Models;
use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['filename', 'type', 'url', 'uploaded_at'];
    protected $useTimestamps = false;
} 