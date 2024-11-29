<x-app-layout>
    <div class="container mx-auto px-4 py-[1rem]">
        <div class="flex justify-center items-center mb-6 space-x-3 flex-col">
            @if (!$buku->isEmpty())
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Daftar Buku</h1>
            @endif
            @if (session('error'))
                <span class="underline items-baseline text-rose-700">
                    {{ session('error') }}
                </span>
            @else
                <span class="underline items-baseline text-emerald-700">
                    {{ session('success') }}
                </span>
            @endif
        </div>

        <div class="relative">
            <div class="overflow-hidden">
                <div class="flex transition-transform duration-300" id="slider-container">
                    @foreach ($buku as $book)
                        <div class="min-w-full md:min-w-[50%] lg:min-w-[33.333%] p-3">
                            <div class=" rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
                                <div class="p-4">
                                    @if ($book->image)
                                        <img class="w-full h-[25rem] object-cover rounded-lg mb-4"
                                            src="{{ asset('images/' . $book->image) }}" alt="{{ $book->Judul }}">
                                    @else
                                        <div
                                            class="w-full h-[25rem] bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between">
                                        <h2 class="text-lg font-medium mb-2">{{ Str::limit($book->Judul, 20, '...') }}
                                        </h2>
                                        @if ($book->ulasan->count() > 0)
                                            <div class="text-sm text-gray-600 text-center">
                                                {{ $book->ulasan->count() }} Ulasan
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-600 text-center">
                                                0 Ulasan
                                            </div>
                                        @endif
                                    </div>

                                    <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                <span>{{ $book->Penulis }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                <span>{{ $book->Penerbit }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">

                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $book->TahunTerbit }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-xl mr-2">★</span>
                                                @if ($book->ulasan->count() > 0)
                                                    <span class="font-bold">{{ $book->ulasan->avg('Rating') }}</span>
                                                @else
                                                    <span class="font-bold"> 0 </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @forelse ($book->kategori as $kategori)
                                            <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                                {{ $kategori->NamaKategori }}
                                            </span>
                                        @empty
                                            <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                                Tidak ada Kategori
                                            </span>
                                        @endforelse
                                    </div>


                                    <div class="flex items-center gap-3 mt-6">
                                        <a href="{{ route('peminjaman.user.index', $book->BukuID) }}"
                                            class=" block text-center w-full mt-4 px-4 py-2 text-sm bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors duration-300">
                                            Pinjam Buku
                                        </a>

                                        <a href="{{ route('koleksi', $book->BukuID) }}"
                                            class=" block text-center w-full mt-4 px-4 py-2 text-sm border border-zinc-700 hover:border-black rounded-lg transition-colors duration-300">
                                            Simpan Buku
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if (empty($buku) || $buku->isEmpty())
            <div class="flex items-center justify-center min-h-[40rem]">
                <span class="bg-white rounded-md p-12 font-extrabold text-xl ">Tidak ada Buku</span>
            </div>
            @else
                <button id="prevButton"
                    class="absolute left-0 top-[43%] -translate-y-1/2 bg-white dark:bg-gray-800 p-3 rounded-r-lg shadow-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400"
                    aria-label="Previous slide">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
                <button id="nextButton"
                    class="absolute right-0 top-[43%] -translate-y-1/2 bg-white dark:bg-gray-800 p-3 rounded-l-lg shadow-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-gray-400"
                    aria-label="Next slide">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <div class="flex justify-center mt-4 gap-2" id="pagination-dots"></div>
            @endif
        </div>
    </div>
</x-app-layout>
