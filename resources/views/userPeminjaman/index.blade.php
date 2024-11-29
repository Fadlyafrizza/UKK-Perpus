<x-app-layout>
    <div class=" mx-auto py-8">
        <div>
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-5">No</th>
                            <th scope="col" class="px-6 py-5">Image</th>
                            <th scope="col" class="px-6 py-5">Book</th>
                            <th scope="col" class="px-6 py-5">Tanggal Peminjaman</th>
                            <th scope="col" class="px-6 py-5">Tanggal Pengembalian</th>
                            <th scope="col" class="px-6 py-5">Status</th>
                            <th scope="col" class="px-6 py-5">Action</th>
                            <th scope="col" class="px-6 py-5">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Fadly_peminjaman as $Fadly_value)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    <img class="object-cover rounded-lg flex items-start justify-center max-h-24 max-w-2xl"
                                        src="{{ asset('images/' . $Fadly_value->buku->image) }}"
                                        alt="{{ $Fadly_value->buku->Judul }}">
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $Fadly_value->buku->Judul }}</td>
                                <td class="px-6 py-4">{{ $Fadly_value->TanggalPeminjaman }}</td>
                                <td class="px-6 py-4">{{ $Fadly_value->TanggalPengembalian }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-sm font-semibold rounded-full underline">
                                        {{ $Fadly_value->StatusPeminjaman }}
                                    </span>
                                    @if ($Fadly_value->denda)
                                        <span class="mt-2 text-red-600 text-sm block">
                                            Denda: Rp {{ number_format($Fadly_value->denda->JumlahDenda, 0, ',', '.') }}
                                        </span>
                                        <p class="text-gray-500 text-xs">
                                            {{ $Fadly_value->denda->Keterangan ?? 'Tidak ada keterangan' }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($Fadly_value->StatusPeminjaman == 'Dipinjam')
                                        <a href="{{ route('peminjaman.user.index', $Fadly_value->BukuID) }}"
                                            class="text-center text-sm text-black hover:underline">
                                            lihat
                                        </a>
                                    @elseif($Fadly_value->StatusPeminjaman == 'Dikembalikan')
                                        <a href="{{ route('peminjaman.user.index', $Fadly_value->BukuID) }}"
                                            class="text-center text-sm text-black hover:underline">
                                            Pinjam Buku
                                        </a>
                                    @elseif($Fadly_value->StatusPeminjaman == 'Diulas')
                                        <span>Terulas</span>
                                    @elseif($Fadly_value->StatusPeminjaman == 'Ditolak')
                                        <a href="{{ route('home') }}"
                                            class="text-center text-sm text-black hover:underline">
                                            Home
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('peminjaman.show', $Fadly_value->PeminjamanID) }}">lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
