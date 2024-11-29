<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Traits\UserTrait;
use Carbon\Carbon;
use App\Models\Buku;
use App\Models\User;
use App\Models\Denda;
// use Barryvdh\DomPDF\PDF;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class LaporanController extends Controller
{
    use UserTrait;

    // public function downloadPdf()
    // {
    //     $peminjaman = Peminjaman::with(['user', 'buku'])->get();

    //     $pdf = PDF::loadView('laporan.peminjaman', compact('peminjaman'));

    //     $this->logActivity('Download Laporan Peminjaman', [
    //         'Laporan' => 'peminjaman'
    //     ]);

    //     return $pdf->download('laporan_peminjaman.pdf');
    // }

    public function index()
    {
        return view('laporan.index');
    }

    public function bookReport(Request $Fadly_request)
    {
        $Fadly_buku = Buku::with('kategori')->get();

        return view('laporan.buku', compact('Fadly_buku'));
    }

    public function loanReport(Request $Fadly_request)
    {
        $Fadly_tanggal = Peminjaman::with(['user', 'buku']);

        if($Fadly_request->Pinjam and $Fadly_request->Kembali){
            $Fadly_tanggal->whereBetween('created_at', [$Fadly_request->Pinjam, $Fadly_request->Kembali]);
        }

        $Fadly_peminjaman = $Fadly_tanggal->get();

        return view('laporan.peminjaman', compact('Fadly_peminjaman'));
    }

    public function fineReport(Request $Fadly_request)
    {
        $Fadly_tanggal = Denda::with(['peminjaman', 'user', 'buku']);

        if($Fadly_request->Pinjam and $Fadly_request->Kembali){
            $Fadly_tanggal->whereBetween('created_at', [$Fadly_request->Pinjam, $Fadly_request->Kembali]);
        }

        $Fadly_denda = $Fadly_tanggal->get();

        return view('laporan.denda', compact('Fadly_denda'));
    }

}
