<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $Fadly_logAktifitas = LogAktivitas::with(['user' => function ($query) {
            $query->withTrashed();
        }])
            ->latest('created_at')
            ->get()
            ->groupBy('aksi');

        return view('activity.index', compact('Fadly_logAktifitas'));
    }
}
