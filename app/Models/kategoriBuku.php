<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class kategoriBuku extends Model
{
    use ModelTrait;

    protected $Fadly_table = 'kategoribuku';
    protected $Fadly_primaryKey = 'KategoriID';
    protected $Fadly_fillable = ['NamaKategori', 'deskripsi'];
    public $Fadly_timestamps = false;

    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'kategoribuku_relasi', 'KategoriID', 'BukuID');
    }
}
