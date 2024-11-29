<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use ModelTrait;

    protected $Fadly_table = 'peminjaman';
    protected $Fadly_primaryKey = 'PeminjamanID';
    protected $Fadly_fillable = [
        'UserID', 'BukuID', 'TanggalPeminjaman',
        'TanggalPengembalian', 'StatusPeminjaman'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'PeminjamanID', 'PeminjamanID');
    }

}
