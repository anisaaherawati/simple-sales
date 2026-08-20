<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $primaryKey = 'id_penjualan';

    public $timestamps = false;

    protected $fillable = [
        'id_pelanggan',
        'id_user',
        'nomor_penjualan',
        'tanggal_penjualan',
        'total_penjualan',
        'status_penjualan',
        'tanggal_validasi',
        'foto_toko',
        'foto_bukti_penyerahan',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'tanggal_validasi' => 'date',
        'tanggal_selesai' => 'date',
        'total_penjualan' => 'decimal:2',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(
            Pelanggan::class,
            'id_pelanggan',
            'id_pelanggan'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function detailPenjualan()
    {
        return $this->hasMany(
            DetailPenjualan::class,
            'id_penjualan',
            'id_penjualan'
        );
    }
}