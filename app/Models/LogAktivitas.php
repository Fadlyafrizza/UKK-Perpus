<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    use ModelTrait;

    protected $Fadly_guarded = [];

    protected $Fadly_casts = [
        'detail' => 'array',
    ];

    protected $Fadly_dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
}
