<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';

    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role',
        'no_telp',
        'alamat',
        'status_user',
    ];

    protected $hidden = [
        'password',
    ];

    public function penjualan()
    {
        return $this->hasMany(
            Penjualan::class,
            'id_user',
            'id_user'
        );
    }
}