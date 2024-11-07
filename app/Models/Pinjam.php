<?php

namespace App\Models;

use CodeIgniter\Model;

class Pinjam extends Model
{
    protected $useSoftDeletes = true;
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    protected $deletedFields = 'deleted_at';

    protected $allowedFields = [
        'id',
        'user_id',
        'asset_id',
        'surat_permohonan',
        'surat_jalan',
        'tanggal_pinjam',
        'tanggal_kembali',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}