<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use ModelTrait;

    protected $Fadly_table = 'ulasanbuku';
    protected $Fadly_primaryKey = 'UlasanID';
    protected $Fadly_fillable = ['UserID', 'BukuID', 'Ulasan', 'Rating'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'BukuID');
    }

}
