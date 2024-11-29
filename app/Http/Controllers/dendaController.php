<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;

class dendaController extends Controller
{
    public function index()
    {
        $Fadly_denda = Denda::with(['user', 'buku'])->get();

        return view('denda.index', compact('Fadly_denda'));
    }

    public function bayar($Fadly_id)
    {
        $Fadly_denda = Denda::findOrFail($Fadly_id);

        $Fadly_denda->StatusPembayaran = 'Dibayar';

        $Fadly_denda->save();

        return to_route('denda.index');
    }
}
