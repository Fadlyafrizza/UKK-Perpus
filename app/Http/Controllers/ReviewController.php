<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(int $Fadly_peminjamanId)
    {
        $Fadly_peminjaman = Peminjaman::findOrFail($Fadly_peminjamanId);

        if ($Fadly_peminjaman->UserID !== Auth::id() || $Fadly_peminjaman->StatusPeminjaman !== 'Dikembalikan') {
            return redirect()->back()->withErrors(['error' => 'Anda tidak dapat memberikan ulasan untuk peminjaman ini.']);
        }

        return view('reviews.create', [
            'peminjaman' => $Fadly_peminjaman,
            'buku' => $Fadly_peminjaman->buku
        ]);
    }
    
    public function store(Request $Fadly_request)
    {
        $Fadly_request->validate([
            'UserID' => 'required|exists:users,UserID',
            'BukuID' => 'required|exists:buku,BukuID',
            'Rating' => 'required|integer|min:1|max:5',
            'Ulasan' => 'required|string|min:3'
        ]);

        $Fadly_peminjaman = Peminjaman::where('UserID', $Fadly_request->UserID)
            ->where('BukuID', $Fadly_request->BukuID)
            ->where('StatusPeminjaman', 'Dikembalikan')
            ->first();

        if (!$Fadly_peminjaman) {
            return back()->with('error', 'Anda harus meminjam dan mengembalikan buku terlebih dahulu sebelum memberikan ulasan.');
        }

        $Fadly_existingReview = Ulasan::where('UserID', $Fadly_request->UserID)
            ->where('BukuID', $Fadly_request->BukuID)
            ->exists();

        if ($Fadly_existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk buku ini.');
        }

        Ulasan::create([
            'UserID' => $Fadly_request->UserID,
            'BukuID' => $Fadly_request->BukuID,
            'Rating' => $Fadly_request->Rating,
            'Ulasan' => $Fadly_request->Ulasan
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }


}
