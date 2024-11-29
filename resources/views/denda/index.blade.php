<x-dashboard-layout>
    <div class="container py-8 mx-auto">
        <h2 class="mb-4 text-2xl font-bold">Daftar Denda</h2>
        <div class="relative overflow-x-auto border shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No Peminjaman
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Username
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Judul
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Denda
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Keterangan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($Fadly_denda as $Fadly_value)
                        <tr class="bg-white border-b dark:bg-gray-800 ">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $Fadly_value->PeminjamanID }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $Fadly_value->user->Username }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $Fadly_value->buku->Judul }}
                            </td>

                            <td class="px-6 py-4">
                                Rp {{ number_format($Fadly_value->JumlahDenda, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $Fadly_value->StatusPembayaran }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $Fadly_value->Keterangan }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($Fadly_value->StatusPembayaran == 'Belum Dibayar')
                                    <form method="POST" action="{{ route('denda.bayar', $Fadly_value->DendaID) }}">
                                        @csrf
                                        <button type="submit" class="underline">
                                            Bayar
                                        </button>
                                    </form>
                                @else
                                    Dibayar
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</x-dashboard-layout>
