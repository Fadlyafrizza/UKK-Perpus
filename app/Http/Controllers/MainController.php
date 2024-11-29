<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Buku;
use App\Models\User;
use App\Models\Denda;
use App\Models\Koleksi;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $Fadly_buku = Buku::with(['kategori', 'ulasan'])->get();

        return view('pages.welcome', [
            'buku' => $Fadly_buku
        ]);
    }

    public function admin()
    {
        $Fadly_buku = Buku::whereDoesntHave('peminjamanAktif')->get();
        $Fadly_user = User::whereNotIn('roles', ['administrator','petugas'])->where('verified', true)->get();

        return view('admin.index', compact('Fadly_user', 'Fadly_buku'));
    }

    public function show(int $Fadly_id)
    {
        $Fadly_buku = Buku::where('BukuID', $Fadly_id)->with(['ulasan', 'peminjaman'])->get();

        return view('pages.index', compact('Fadly_buku'));
    }

    public function store(Request $Fadly_request)
    {

        if (Auth::user()->isAdmin()) {
            return redirect()->back()->withErrors(['error' => 'Admin tidak diperbolehkan meminjam buku.']);
        }

        $Fadly_validate = $Fadly_request->validate([
            'UserID' => 'required|exists:users,UserID',
            'BukuID' => 'required|exists:buku,BukuID',
            'Fadly_TanggalPeminjaman' => 'required|date',
            'Fadly_TanggalPengembalian' => 'required|date|after_or_equal:Fadly_TanggalPeminjaman|before_or_equal:' . now()->addDays(14)->toDateString(),
        ]);

        $Fadly_peminjaman = Peminjaman::create([
            'UserID' => Auth::id(),
            'BukuID' => $Fadly_validate['BukuID'],
            'TanggalPeminjaman' => $Fadly_validate['Fadly_TanggalPeminjaman'],
            'TanggalPengembalian' => $Fadly_validate['Fadly_TanggalPengembalian'],
            'StatusPeminjaman' => 'Tertunda',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return to_route('home');
    }
    public function peminjaman(int $Fadly_id)
    {
        if (Auth::user() == null) {
            return to_route('home')->with('alert', 'Login terlebih dahulu');
        }

        $Fadly_koleksi = Koleksi::where('UserID', Auth::id())
            ->where('BukuID', $Fadly_id)
            ->first();

        if ($Fadly_koleksi) {
            return redirect()->route('home')->with('error', 'Buku "' . $Fadly_koleksi->buku->Judul . '" sudah Anda koleksi.');
        }

        $Fadly_create = Koleksi::create([
            'UserID' => Auth::id(),
            'BukuID' => $Fadly_id
        ]);

        return redirect()->route('home')->with('success', 'Buku "' . $Fadly_create->buku->Judul . '" berhasil ditambahkan ke koleksi.');
    }


    public function returnBook(Request $request, $Fadly_peminjamanId)
    {
        $Fadly_peminjaman = Peminjaman::findOrFail($Fadly_peminjamanId);

        if ($Fadly_peminjaman->UserID !== Auth::id() && !Auth::user()->isAdmin()) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak memiliki akses untuk mengembalikan buku ini.']);
        }

        $tanggalPengembalianActual = Carbon::now();

        if ($tanggalPengembalianActual->gt($Fadly_peminjaman->TanggalPengembalian)) {
            $jumlahDenda = Denda::calculateDenda(
                $Fadly_peminjaman->TanggalPengembalian,
                $tanggalPengembalianActual
            );

            Denda::create([
                'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
                'UserID' => $Fadly_peminjaman->UserID,
                'JumlahDenda' => $jumlahDenda,
                'StatusPembayaran' => 'Belum Dibayar',
                'TanggalDenda' => $tanggalPengembalianActual,
                'Keterangan' => 'Denda keterlambatan pengembalian buku'
            ]);

            $message = "Buku berhasil dikembalikan. Anda dikenakan denda Rp " . number_format($jumlahDenda, 0, ',', '.') . " karena terlambat mengembalikan.";
        } else {
            $message = "Buku berhasil dikembalikan tepat waktu.";
        }

        $Fadly_peminjaman->update([
            'StatusPeminjaman' => 'Selesai'
        ]);

        return redirect()->back()->with('success', $message);
    }
}
