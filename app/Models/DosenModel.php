<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    // Nama tabel dalam database yang digunakan oleh model ini
    protected $table            = 'dosen';

    // Nama kolom yang menjadi primary key di tabel 'dosen'
    protected $primaryKey       = 'id_dosen';
    
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Daftar kolom yang boleh diisi atau diubah melalui method Create dan Update
    protected $allowedFields    = ['id_dosen', 'nama_dosen', 'email', 'no_telp', 'password'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
