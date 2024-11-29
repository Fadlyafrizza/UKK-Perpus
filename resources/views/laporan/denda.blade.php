<x-guest-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6 space-x-3 sembunyikan">
            <div class="flex justify-between">
                <div class="space-x-2 mt-2">
                    <a onclick="window.print()" type="submit"
                        class="bg-zinc-700 text-white px-4 py-2 rounded hover:bg-black cursor-pointer">
                        Download Pdf
                    </a>

                    <a href="{{ route('laporan.index') }}"
                        class=" text-black px-4 py-2 rounded border-zinc-700 border hover:border-black">
                        Back
                    </a>
                </div>
                <div class="">
                    <form action="">
                        <input type="date" class=" p-2 rounded-md border-gray-300 shadow-sm"
                            onchange="this.form.submit()" name="Pinjam" value="{{ Request('Pinjam') }}">
                        <input type="date" class=" p-2 rounded-md border-gray-300 shadow-sm"
                            onchange="this.form.submit()" name="Kembali" value="{{ Request('Kembali') }}">
                    </form>
                </div>
            </div>
        </div>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200 text-xs">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">No Pinjaman</th>
                    <th class="border border-gray-300 px-4 py-2">Username</th>
                    <th class="border border-gray-300 px-4 py-2">Judul Buku</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal Peminjaman</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal Pengembalian</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Denda</th>
                    <th class="border border-gray-300 px-4 py-2">Status Pembayaran</th>
                    <th class="border border-gray-300 px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Fadly_denda as $Fadly_value)
                    <tr class="hover:bg-gray-100 text-sm">
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $Fadly_value->peminjaman->PeminjamanID }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $Fadly_value->user->Username }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $Fadly_value->buku->Judul }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $Fadly_value->peminjaman->TanggalPeminjaman }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $Fadly_value->peminjaman->TanggalPengembalian }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            Rp {{ number_format($Fadly_value->JumlahDenda, 0, ',', '.') }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $Fadly_value->StatusPembayaran }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $Fadly_value->Keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-guest-layout>
