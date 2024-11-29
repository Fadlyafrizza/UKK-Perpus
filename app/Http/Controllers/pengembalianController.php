<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;

class pengembalianController extends Controller
{

    public function bukti($Fadly_id)
    {
        $Fadly_peminjaman = Peminjaman::with(['buku', 'user'])->findOrFail($Fadly_id);

        return view('userPeminjaman.show', compact('Fadly_peminjaman'));
    }

    public function index()
    {
         $Fadly_peminjaman = Peminjaman::with(['user', 'buku', 'denda'])
         ->where('UserID', auth()->id())
         ->get();
        return view('userPeminjaman.index', compact('Fadly_peminjaman'));
    }

    // public function return($id)
    // {
    //     $peminjaman = Peminjaman::findOrFail($id);

    //     if ($peminjaman->UserID !== auth()->id()) {
    //         return back()->with('error', 'Unauthorized action');
    //     }

    //     $peminjaman->update([
    //         'StatusPeminjaman' => 'Dikembalikan',
    //         'TanggalPengembalian' => now()
    //     ]);

    //     return back()->with('success', 'Buku berhasil dikembalikan');
    // }
}
