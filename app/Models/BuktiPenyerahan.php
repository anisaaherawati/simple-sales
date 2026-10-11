<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penjualan;

class BuktiPenyerahan extends Model
{
    protected $table = 'bukti_penyerahans';

    protected $fillable = [
        'id_penjualan',
        'foto',
        'alasan_penolakan',
        'status',
        'tanggal_upload',
        'tanggal_konfirmasi',
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
        'tanggal_konfirmasi' => 'datetime',
    ];

    public function penjualan()
    {
        return $this->belongsTo(
            Penjualan::class,
            'id_penjualan',
            'id_penjualan'
        );
    }
}