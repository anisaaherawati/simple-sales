<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    public $timestamps = false;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori_produk',
        'harga_produk',
        'stok_produk',
        'satuan_produk',
        'status_produk',
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(
            DetailPenjualan::class,
            'id_produk',
            'id_produk'
        );
    }
}