<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class KategoriRelation extends Model
{
    use ModelTrait;

    protected $Fadly_table = 'kategoribuku_relasi';

    protected $Fadly_guarded = [];

}
