<x-dashboard-layout>
    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Daftar Buku</h1>

            <div class="flex items-center gap-4">

                <a href="{{ route('buku.index') }}" class=" text-gray-600 hover:text-black">
                    Bersihkan
                </a>


                <form action="{{ route('buku.index') }}" method="GET" class="relative">
                    <input type="text" name="search" placeholder="Cari buku..." value="{{ $search ?? '' }}"
                        class="w-64 py-2 pl-10 pr-4 border border-black rounded-lg text-zinc-600 focus:outline-none focus:ring-1 focus:ring-zinc-400">
                    <button type="submit" class="absolute left-3 top-2.5">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>

                <a href="{{ route('buku.create') }}"
                    class="inline-flex items-center px-4 py-2 transition-colors border border-black rounded-lg text-zinc-500 hover:text-black focus:outline-none focus:ring-1 focus:ring-black focus:text-black">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Buku
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded-lg dark:bg-green-200"
                role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if ($buku->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-600 dark:text-gray-400">No books found matching your search criteria.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($buku as $book)
                    <div
                        class="overflow-hidden bg-white rounded-lg shadow-lg transition-transform hover:scale-[1.02] dark:bg-gray-800">
                        <div class="p-6">
                            @if (!Auth::user()->isAdmin())
                                <a href="{{ $book->peminjaman()->whereIn('StatusPeminjaman', ['Dipinjam', 'Tertunda'])->count() > 0? '/buku': route('peminjaman.create', $book->BukuID) }}"
                                    class="{{ $book->peminjaman()->whereIn('StatusPeminjaman', ['Dipinjam', 'Tertunda'])->count() > 0? 'cursor-not-allowed opacity-70': '' }}">
                                    @if ($book->image)
                                        <img class="object-cover mb-4 rounded-lg flex items-start justify-center aspect-[3/4]"
                                            src="{{ asset('images/' . $book->image) }}" alt="{{ $book->Judul }}">
                                    @else
                                        <div
                                            class="mb-4 bg-gray-200 rounded-lg dark:bg-gray-700 aspect-[3/4] flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                            @else
                                @if ($book->image)
                                    <img class="object-cover mb-4 rounded-lg flex items-start justify-center aspect-[3/4]"
                                        src="{{ asset('images/' . $book->image) }}" alt="{{ $book->Judul }}">
                                @else
                                    <div
                                        class="mb-4 bg-gray-200 rounded-lg dark:bg-gray-700 aspect-[3/4] flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                @endif
                            @endif

                            <h2 class="mb-3 text-xl font-semibold text-gray-900 dark:text-white">{!! Str::limit($book->Judul, 25) !!}
                            </h2>

                            <div class="space-y-2 text-gray-600 dark:text-gray-300">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ $book->Penulis }}</span>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="
none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span>{{ $book->Penerbit }}</span>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>{{ $book->TahunTerbit }}</span>
                                </div>
                                @if ($book->kategori->isNotEmpty())
                                    <div class="flex items-center gap-1">
                                        @foreach ($book->kategori as $kategori)
                                            <span
                                                class="inline-block px-2 py-1 text-xs font-semibold bg-gray-200 rounded-md text-gray">
                                                {{ $kategori->NamaKategori }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="flex items-center gap-1">
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold bg-gray-200 rounded-md text-gray">
                                            Tidak ada Kategori
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-3 mt-6">
                                <a href="{{ route('buku.edit', $book) }}"
                                    class="flex items-center justify-center flex-1 px-4 py-2 text-sm font-medium text-black transition-colors border border-black rounded-lg focus:outline-none focus:ring-1 focus:ring-black">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>

                                <form action="{{ route('buku.destroy', $book) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')"
                                        class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white transition-colors rounded-lg bg-zinc-700 hover:text-white hover:bg-black focus:outline-none focus:ring-1 focus:ring-black">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-dashboard-layout>
