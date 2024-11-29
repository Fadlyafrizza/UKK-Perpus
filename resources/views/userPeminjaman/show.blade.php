<x-guest-layout>
    <div class=" flex items-center justify-center pt-[7rem]">
        <div class="max-w-2xl w-full border border-black">
            <div class="bg-white rounded-lg overflow-hidden transform transition-all">
                <div class="bg-zinc-700 p-6 sm:p-8">
                    <h2 class="text-3xl font-extrabold text-white text-center">Bukti Peminjaman Buku</h2>
                    <p class="mt-2 text-center text-blue-100">Perpustakaan StudyStacks</p>
                </div>
                <div class="p-6 sm:p-8 space-y-6">
                    <div class="space-y-4">
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4">
                            <span class="text-sm font-medium text-gray-500">Nama Peminjam</span>
                            <span class="text-lg font-semibold text-gray-900">
                                {{ !empty($Fadly_peminjaman->user->NamaLengkap) ? $Fadly_peminjaman->user->NamaLengkap : $Fadly_peminjaman->user->Username }}
                            </span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4">
                            <span class="text-sm font-medium text-gray-500">Judul Buku</span>
                            <span
                                class="text-lg font-semibold text-gray-900 sm:text-right">{{ $Fadly_peminjaman->buku->Judul }}</span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4">
                            <span class="text-sm font-medium text-gray-500">Tanggal Peminjaman</span>
                            <span
                                class="text-lg font-semibold text-gray-900">{{ $Fadly_peminjaman->TanggalPeminjaman }}</span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4">
                            <span class="text-sm font-medium text-gray-500">Tanggal Pengembalian</span>
                            <span
                                class="text-lg font-semibold text-gray-900">{{ $Fadly_peminjaman->TanggalPengembalian }}</span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-200 pb-4">
                            <span class="text-sm font-medium text-gray-500">Status Peminjaman</span>
                            <span
                                class="text-lg font-semibold {{ $Fadly_peminjaman->StatusPeminjaman === 'Dipinjam' ? 'text-yellow-600' : 'text-green-600' }}">
                                {{ $Fadly_peminjaman->StatusPeminjaman }}
                            </span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <span class="text-sm font-medium text-gray-500">Denda</span>
                            <span
                                class="text-lg font-semibold {{ $Fadly_peminjaman->denda ? 'text-red-600' : 'text-green-600' }}">
                                @if ($Fadly_peminjaman->denda)
                                    Rp {{ number_format($Fadly_peminjaman->denda->JumlahDenda, 0, ',', '.') }}
                                @else
                                    Tidak ada
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="text-center mt-8">
                        <button onclick="window.print()"
                            class=" sembunyikan inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-zinc-700">
                            Cetak Bukti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
