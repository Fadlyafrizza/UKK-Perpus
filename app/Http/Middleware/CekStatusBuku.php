<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekStatusBuku
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $Fadly_request, Closure $Fadly_next)
    {
        $Fadly_bookId = $Fadly_request->route('Fadly_id');
        $Fadly_isBookUnavailable = Peminjaman::where('BukuID', $Fadly_bookId)
            ->whereIn('StatusPeminjaman', ['Dipinjam', 'Tertunda'])
            ->exists();

        if ($Fadly_isBookUnavailable) {
            return redirect()->back()->withErrors(['error' => 'Buku ini tidak dapat dipinjam karena statusnya sedang Dipinjam atau Tertunda.']);
        }

        return $Fadly_next($Fadly_request);
    }
}
