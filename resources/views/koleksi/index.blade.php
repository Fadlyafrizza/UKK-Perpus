<x-app-layout>
    <div class="px-2 container mx-auto py-8">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="text-xs text-gray-700 uppercase text-left">
                    <tr class="border-b">
                        <th scope="col" class="px-2 py-1 ">No</th>
                        <th scope="col" class="px-2 py-1 ">Image</th>
                        <th scope="col" class="px-2 py-1 ">Judul</th>
                        <th scope="col" class="px-2 py-1 ">Penulis</th>
                        <th scope="col" class="px-2 py-1 ">Penerbit</th>
                        <th scope="col" class="px-2 py-1 ">Tahun</th>
                        <th scope="col" class="px-2 py-1 ">Kategori</th>
                        <th scope="col" class="px-2 py-1 ">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Fadly_buku as $index => $Fadly_value)
                        <tr class="border-b">
                            <td class="px-2 py-1 text-sm">{{ $index + 1 }}</td>
                            <td class="px-2 py-1">
                                @if ($Fadly_value->buku->image)
                                    <img src="{{ asset('images/' . $Fadly_value->buku->image) }}"
                                        alt="{{ $Fadly_value->buku->Judul }}" class="w-12 h-16 object-cover">
                                @else
                                    <div class="w-12 h-16 bg-gray-50 flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 py-1 text-sm">{{ Str::limit($Fadly_value->buku->Judul, 30, '...') }}</td>
                            <td class="px-2 py-1 text-sm">{{ $Fadly_value->buku->Penulis }}</td>
                            <td class="px-2 py-1 text-sm">{{ $Fadly_value->buku->Penerbit }}</td>
                            <td class="px-2 py-1 text-sm">{{ $Fadly_value->buku->TahunTerbit }}</td>
                            <td class="px-2 py-1 text-sm">
                                @if ($Fadly_value->buku->kategori->isNotEmpty())
                                    @foreach ($Fadly_value->kategori as $kategori)
                                        <span class="text-xs">
                                            {{ $kategori->NamaKategori }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="text-xs">Tidak ada kategori</span>
                                @endif
                            </td>
                            <td class="px-2 py-1 text-sm">
                                <a href="{{ route('peminjaman.user.index', $Fadly_value->BukuID) }}"
                                    class="mr-3 font-medium hover:underline">Pinjam</a>
                                <form action="{{ route('koleksi.destroy', $Fadly_value->KoleksiID) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-black text-bold hover:underline"
                                        onclick="return confirm('Apakah kamu serius ingin menghapus Buku ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
