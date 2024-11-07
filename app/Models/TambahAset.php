<?php

namespace App\Models;

use CodeIgniter\Model;

class TambahAset extends Model
{
    protected $useSoftDeletes = true;
    protected $table = 'penambahan_aset';
    protected $primaryKey = 'id';
    protected $deletedFields = 'deleted_at';

    protected $allowedFields = [
        'id',
        'kode_barang',
        'merk',
        'type',
        'tahun_pembuatan',
        'no_bpkb',
        'no_stnk',
        'kondisi',
        'no_sk_psp',
        'no_polisi',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}