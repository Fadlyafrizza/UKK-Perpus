<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Koleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class koleksiController extends Controller
{
    public function index()
    {
        $Fadly_buku = Koleksi::where('UserID', Auth::id())->with('buku')->get();
        return view('koleksi.index', compact('Fadly_buku'));
    }

    public function destroy($Fadly_id)
    {
        $Fadly_koleksi = Koleksi::findOrFail($Fadly_id);

        $Fadly_koleksi->delete();

        return to_route('koleksi.index');
    }
}
