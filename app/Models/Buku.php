<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Buku extends Model
{
    use HasFactory, ModelTrait;

    protected $Fadly_table = 'buku';
    protected $Fadly_primaryKey = 'BukuID';

    protected $Fadly_guarded = [];

    public function kategori()
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategoribuku_relasi', 'BukuID', 'KategoriID')
                    ->select('kategoribuku.KategoriID', 'kategoribuku.NamaKategori');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'BukuID');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'BukuID');
    }

    public function scopeWithUlasanCount(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount(['ulasan' => function(Builder $q) use ($from, $to) {
            if ($from) {
                $q->where('created_at', '>=', $from);
            }
            if ($to) {
                $q->where('created_at', '<=', $to);
            }
        }])
        ->orderBy('ulasan_count', 'desc');
    }

    public function peminjamanAktif()
    {
        return $this->hasMany(Peminjaman::class, 'BukuID', 'BukuID')
            ->where('StatusPeminjaman', '!=', 'dikembalikan');
    }


     public function scopeWithAvgRating(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvg(['ulasan' => function(Builder $q) use ($from, $to) {
            if ($from) {
                $q->where('created_at', '>=', $from);
            }
            if ($to) {
                $q->where('created_at', '<=', $to);
            }
        }], 'Rating')
        ->orderBy('ulasan_avg_rating', 'desc');
    }
}
