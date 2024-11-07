<?php

namespace App\Models;

use CodeIgniter\Model;

class Kembali extends Model
{
    protected $useSoftDeletes = true;
    protected $table = 'pengembalian';
    protected $primaryKey = 'id';
    protected $deletedFields = 'deleted_at';

    protected $allowedFields = [
        'id',
        'peminjaman_id',
        'berita_acara_pengembalian',
        'tanggal_pengembalian',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}