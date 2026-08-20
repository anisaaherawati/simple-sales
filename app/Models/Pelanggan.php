<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $primaryKey = 'id_pelanggan';

    public $timestamps = false;

    protected $fillable = [
        'kode_pelanggan',
        'nama_pelanggan',
        'nama_toko',
        'alamat_pelanggan',
        'no_wa',
        'status_pelanggan',
    ];

    public function penjualan()
    {
        return $this->hasMany(
            Penjualan::class,
            'id_pelanggan',
            'id_pelanggan'
        );
    }
}