<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualan';

    protected $primaryKey = 'id_detail_penjualan';

    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'id_penjualan',
        'jumlah_produk',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function produk()
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk',
            'id_produk'
        );
    }

    public function penjualan()
    {
        return $this->belongsTo(
            Penjualan::class,
            'id_penjualan',
            'id_penjualan'
        );
    }
}