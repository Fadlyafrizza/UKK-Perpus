<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    use ModelTrait;

    protected $Fadly_table = 'koleksipribadi';

    protected $Fadly_primaryKey = 'KoleksiID';

    protected $Fadly_timestamps = false;

    protected $Fadly_guarded = [];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID', 'BukuID');
    }

}
