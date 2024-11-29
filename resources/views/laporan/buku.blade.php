<x-guest-layout>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6"></h1>
        <div class="mb-6 space-x-3 sembunyikan">
            {{-- <button onclick="window.print()" class="bg-zinc-700 text-white px-4 py-2 rounded hover:bg-black ">
                Download Pdf
            </button> --}}

            <a href="{{ route('laporan.books') }}" class="bg-zinc-700 text-white px-4 py-2 rounded hover:bg-black">
                Download Pdf
            </a>

            <a href="{{ route('laporan.index') }}"
                class=" text-black px-4 py-2 rounded border-zinc-700 border hover:border-black">
                Back
            </a>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">Judul</th>
                    <th class="border border-gray-300 px-4 py-2">Penulis</th>
                    <th class="border border-gray-300 px-4 py-2">Kategori</th>
                    <th class="border border-gray-300 px-4 py-2">Ulasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Fadly_buku as $book)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $book->Judul }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $book->Penulis }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($book->kategori->isNotEmpty())
                                @foreach ($book->kategori as $kategori)
                                    <span class="inline-block px-2 py-1 text-sm  text-gray">
                                        {{ $kategori->pluck('Namakategori')->join(', ') }}
                                    </span>
                                @endforeach
                            @else
                                <span class="inline-block px-2 py-1 text-sm text-gray">
                                    Tidak ada Kategori
                                </span>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2 ">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900 mr-1">
                                    {{ $book->ulasan->count() > 0 ? number_format($book->ulasan->avg('Rating'), 1) : '0' }}
                                </span>
                                <span class="text-base mr-2">★</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
</x-guest-layout>
