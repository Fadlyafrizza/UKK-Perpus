<?php

namespace App\Traits;

use App\Models\LogAktivitas;

trait UserTrait
{
    protected function logActivity($aksi, $detail)
    {
        LogAktivitas::create([
            'UserID' => auth()->id(),
            'aksi' => $aksi,
            'detail' => $detail
        ]); 
    }
}
