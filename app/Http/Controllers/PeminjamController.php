<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Buku;
use App\Models\User;
use App\Models\Denda;
use App\Traits\UserTrait;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    use UserTrait;

    public function index()
    {

$denda = Denda::latest()->get();


        $Fadly_peminjaman = Peminjaman::latest()->get();
        return view('peminjaman.index', compact('Fadly_peminjaman', 'denda'));
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
            'UserID' => $Fadly_validate['UserID'],
            'BukuID' => $Fadly_validate['BukuID'],
            'TanggalPeminjaman' => $Fadly_validate['Fadly_TanggalPeminjaman'],
            'TanggalPengembalian' => $Fadly_validate['Fadly_TanggalPengembalian'],
            'StatusPeminjaman' => 'Dipinjam',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('menambah peminjaman', [
                'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
                'UserID | User' => $Fadly_peminjaman->UserID . ' | ' .  $Fadly_peminjaman->user->Username,
                'BukuID | Judul' => $Fadly_peminjaman->BukuID . ' | ' . $Fadly_peminjaman->buku->Judul,
                'TanggalPeminjaman' => Carbon::parse($Fadly_peminjaman->TanggalPeminjaman)->translatedFormat('d F Y'),
                'TanggalPengembalian' => Carbon::parse($Fadly_peminjaman->TanggalPengembalian)->translatedFormat('d F Y'),
                'StatusPeminjaman' => $Fadly_peminjaman->StatusPeminjaman,
            ]);
        }

        return to_route('buku.index');
    }

    public function create(int $Fadly_id)
    {
        $Fadly_buku = Buku::with(['ulasan', 'peminjaman'])->findOrFail($Fadly_id);

        $Fadly_users = User::whereNotIn('roles', ['administrator', 'petugas'])
            ->withCount(['peminjaman' => function ($query) {
                $query->whereIn('StatusPeminjaman', ['Dipinjam', 'Tertunda']);
            }])
            ->get();

        return view('peminjaman.create', [
            'buku' => $Fadly_buku,
            'users' => $Fadly_users
        ]);
    }

    public function createDenda(Request $Fadly_request, $Fadly_id)
    {
        $Fadly_peminjaman = Peminjaman::findOrFail($Fadly_id);

        $Fadly_jenisDenda = $Fadly_request->input('jenis_denda', []);

        if (empty($Fadly_jenisDenda)) {
            return redirect()->route('peminjaman.index')->with('error', 'Pilih setidaknya satu jenis denda.');
        }

        $Fadly_totalDenda = 0;
        $Fadly_keterangan = [];

        foreach ($Fadly_jenisDenda as $jenis) {
            switch ($jenis) {
                case 'keterlambatan':
                    $tanggalKembali = Carbon::parse($Fadly_peminjaman->TanggalPengembalian);
                    $tanggalSekarang = Carbon::now();
                    $keterlambatan = $tanggalSekarang->diffInDays($tanggalKembali, false);
                    $jumlahDenda = $keterlambatan * 1000;
                    $Fadly_keterangan[] = "Terlambat";
                    break;
                case 'kerusakan_ringan':
                    $jumlahDenda = 50000;
                    $Fadly_keterangan[] = "Kerusakan ringan";
                    break;
                case 'kerusakan_berat':
                    $jumlahDenda = 100000;
                    $Fadly_keterangan[] = "Kerusakan berat";
                    break;
                default:
                    break;
            }

            $Fadly_totalDenda += $jumlahDenda;
        }

        $Fadly_denda = Denda::create([
            'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
            'UserID' => $Fadly_peminjaman->UserID,
            'BukuID' => $Fadly_peminjaman->BukuID,
            'JumlahDenda' => abs($Fadly_totalDenda),
            'StatusPembayaran' => 'Belum Dibayar',
            'TanggalDenda' => Carbon::now(),
            'Keterangan' => implode(', ', $Fadly_keterangan)
        ]);

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('membuat denda', [
                'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
                'UserID | User' => $Fadly_peminjaman->UserID . ' | ' .  $Fadly_peminjaman->user->Username,
                'BukuID | Judul' => $Fadly_peminjaman->BukuID . ' | ' . $Fadly_peminjaman->buku->Judul,
                'JumlahDenda' => 'Rp ' . number_format(abs($Fadly_totalDenda), 0, ',', '.'),
                'JenisDenda' => implode(', ', $Fadly_keterangan)
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Denda berhasil dibuat.');
    }

    public function update($Fadly_id)
    {
        $Fadly_peminjaman = Peminjaman::findOrFail($Fadly_id);
        $Fadly_peminjaman->StatusPeminjaman = 'Dikembalikan';

        $tanggalKembali = Carbon::now();
        $tanggalSeharusnya = Carbon::parse($Fadly_peminjaman->TanggalPengembalian);

        if ($tanggalKembali->greaterThan($tanggalSeharusnya)) {
            $keterlambatan = round($tanggalSeharusnya->diffInDays($tanggalKembali));

            $jumlahDenda = $keterlambatan * 10000;

            Denda::create([
                'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
                'UserID' => $Fadly_peminjaman->UserID,
                'BukuID' => $Fadly_peminjaman->BukuID,
                'JumlahDenda' => $jumlahDenda,
                'StatusPembayaran' => 'Belum Dibayar',
                'TanggalDenda' => $tanggalKembali,
                'Keterangan' => "Denda keterlambatan {$keterlambatan} hari"
            ]);

            if (!Auth::user()->isAdmin()) {
                $this->logActivity('membuat denda', [
                    'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
                    'UserID' => $Fadly_peminjaman->UserID,
                    'JumlahDenda' => $jumlahDenda,
                    'Keterlambatan' => $keterlambatan . ' hari'
                ]);
            }
        }

        $Fadly_peminjaman->save();

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('mengembalikan peminjaman', [
                'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
                'UserID | User' => $Fadly_peminjaman->UserID . ' | ' .  $Fadly_peminjaman->user->Username,
                'BukuID | Judul' => $Fadly_peminjaman->BukuID . ' | ' . $Fadly_peminjaman->buku->Judul,
                'TanggalPeminjaman' => Carbon::parse($Fadly_peminjaman->TanggalPeminjaman)->translatedFormat('d F Y'),
                'TanggalPengembalian' => Carbon::parse($Fadly_peminjaman->TanggalPengembalian)->translatedFormat('d F Y'),
                'StatusPeminjaman' => $Fadly_peminjaman->StatusPeminjaman,
            ]);
        }

        return redirect()->route('peminjaman.index');
    }


    public function verify($Fadly_id)
    {
        $Fadly_peminjaman = Peminjaman::findOrFail($Fadly_id);
        $Fadly_peminjaman->StatusPeminjaman = 'Dipinjam';
        $Fadly_peminjaman->save();

        if(!Auth::user()->isAdmin()) {
            $this->logActivity('memverifikasi peminjaman', [
                'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
                'UserID | User' => $Fadly_peminjaman->UserID . ' | ' .  $Fadly_peminjaman->user->Username,
                'BukuID | Judul' => $Fadly_peminjaman->BukuID . ' | ' . $Fadly_peminjaman->buku->Judul,
                'TanggalPeminjaman' => Carbon::parse($Fadly_peminjaman->TanggalPeminjaman)->translatedFormat('d F Y'),
                'TanggalPengembalian' => Carbon::parse($Fadly_peminjaman->TanggalPengembalian)->translatedFormat('d F Y'),
                'StatusPeminjaman' => $Fadly_peminjaman->StatusPeminjaman,
            ]);
        }

        return redirect()->route('peminjaman.index');
    }

    public function destroy($Fadly_id)
    {
        $Fadly_peminjaman = Peminjaman::findOrFail($Fadly_id);

        $Fadly_peminjaman->StatusPeminjaman = 'Ditolak';

        if (!Auth::user()->isAdmin()) {
            $this->logActivity('menolak peminjaman', [
                'PeminjamanID' => $Fadly_peminjaman->PeminjamanID,
                'UserID | User' => $Fadly_peminjaman->UserID . ' | ' .  $Fadly_peminjaman->user->Username,
                'BukuID | Judul' => $Fadly_peminjaman->BukuID . ' | ' . $Fadly_peminjaman->buku->Judul,
                'TanggalPeminjaman' => Carbon::parse($Fadly_peminjaman->TanggalPeminjaman)->translatedFormat('d F Y'),
                'TanggalPengembalian' => Carbon::parse($Fadly_peminjaman->TanggalPengembalian)->translatedFormat('d F Y'),
                'StatusPeminjaman' => $Fadly_peminjaman->StatusPeminjaman,
            ]);
        }

        $Fadly_peminjaman->save();

        return redirect()->back()->with('success', 'User has been deleted successfully.');
    }

}
