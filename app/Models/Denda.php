<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;

class Denda extends Model
{
    use ModelTrait;

    protected $Fadly_table = 'denda';
    protected $Fadly_primaryKey = 'DendaID';

    protected $Fadly_guarded = [];

    protected $Fadly_incrementing = true;

    public function getIncrementing()
    {
        return $this->Fadly_incrementing ?? [];
    }

    protected $Fadly_casts = [
        'JumlahDenda' => 'decimal:2',
        'TanggalDenda' => 'date'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'PeminjamanID', 'PeminjamanID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }

    public static function calculateDenda($tanggalPengembalian, $tanggalActual)
    {
        $denda_per_hari = 3000;
        $selisih_hari = max(0, strtotime($tanggalActual) - strtotime($tanggalPengembalian)) / (60 * 60 * 24);
        return ceil($selisih_hari) * $denda_per_hari;
    }

}
