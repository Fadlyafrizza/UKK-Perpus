<?php

// namespace App\Commands;

// use Illuminate\Console\Command;
// use App\Models\Peminjaman;
// use App\Models\Denda;
// use Carbon\Carbon;

// class CheckOverdueBooksAndCreateFines extends Command
// {
//     protected $signature = 'library:check-overdue';
//     protected $description = 'Check for overdue books and create fines';

//     public function handle()
//     {
//         $overdueLoans = Peminjaman::where('TanggalPengembalian', '<', Carbon::now())
//             ->whereNotIn('StatusPeminjaman', ['Dikembalikan', 'Ditolak', 'Tertunda', 'Diulas'])
//             ->get();


//         foreach ($overdueLoans as $loan) {
//             $daysOverdue = Carbon::now()->diffInDays($loan->TanggalPengembalian);

//             if ($daysOverdue > 1) {
//                 $fine = new Denda();
//                 $fine->PeminjamanID = $loan->PeminjamanID;
//                 $fine->UserID = $loan->UserID;
//                 $fine->BukuID = $loan->BukuID;
//                 $fine->JumlahDenda = $daysOverdue * 3000;
//                 $fine->StatusPembayaran = 'Belum Dibayar';
//                 $fine->TanggalDenda = Carbon::now();
//                 $fine->Keterangan = "Denda keterlambatan {$daysOverdue} hari";
//                 $fine->save();

//                 $loan->StatusPeminjaman = 'Terlambat';
//                 $loan->save();

//                 $this->info("Created fine for loan ID: {$loan->PeminjamanID}");
//             }
//         }

//         $this->info('Finished checking for overdue books and creating fines.');
//     }
// }
