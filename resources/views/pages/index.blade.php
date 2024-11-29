<x-app-layout>
    <div class="mx-auto px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white p-8 rounded-lg shadow-lg">
                    @foreach ($Fadly_buku as $item)
                        @php
                            $isPeminjaman = $item
                                ->peminjaman()
                                ->where('StatusPeminjaman', 'Dipinjam')
                                ->where('TanggalPengembalian', '>=', now())
                                ->exists();
                            $Fadly_rating = $item->ulasan->avg('Rating') ?? 0;
                            $Fadly_ulasan = $item->ulasan->count();
                        @endphp

                        <div class="border-b last:border-b-0 mb-8">
                            <div class="flex flex-col lg:flex-row gap-8">
                                <div class="w-full lg:w-1/3">
                                    <img src="{{ $item->image ? asset('images/' . $item->image) : '/api/placeholder/300/450' }}"
                                        alt="{{ $item->Judul }}" class="w-full h-auto rounded-lg shadow-md" />
                                </div>
                                <div class="w-full lg:w-2/3">
                                    <h1 class="text-4xl font-bold mb-4">{{ $item->Judul }}</h1>
                                    <div class="space-y-3 text-lg text-gray-700">
                                        <p><span class="font-semibold">Author:</span> {{ $item->Penulis }}</p>
                                        <p><span class="font-semibold">Publisher:</span> {{ $item->Penerbit }}</p>
                                        <p><span class="font-semibold">Publication Year:</span> {{ $item->TahunTerbit }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <h3 class="text-2xl font-bold mb-6">Reviews</h3>
                                <div class="flex items-center gap-3 mb-6">
                                    <x-star-rating :rating="$Fadly_rating" />
                                    <span class="text-lg text-gray-700">
                                        {{ number_format($Fadly_rating, 1) }} ({{ $Fadly_ulasan }}
                                        {{ Str::plural('review', $Fadly_ulasan) }})
                                    </span>
                                </div>
                                <div class="space-y-6">

                                    @foreach ($item->ulasan->take(3) as $ulasan)
                                        <div class="bg-gray-100 rounded-md p-6 pb-6">
                                            <div class="flex justify-between items-start mb-3">
                                                <div>
                                                    <p class="font-semibold text-lg">
                                                        {{ $ulasan->user->Username ?? 'Anonymous' }}</p>
                                                    <div class="flex items-center">
                                                        <x-star-rating :rating="$ulasan->Rating" />
                                                    </div>
                                                </div>
                                                <span class="text-sm text-gray-500">
                                                    {{ $ulasan->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-gray-700">{{ $ulasan->Ulasan }}</p>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @php
                $Fadly_isPeminjaman = $item
                    ->peminjaman()
                    ->where('UserID', auth()->id())
                    ->where('StatusPeminjaman', 'Dikembalikan')
                    ->exists();
            @endphp

            @if ($Fadly_isPeminjaman && !$item->ulasan()->where('UserID', auth()->id())->exists())
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-6">Berikan Ulasan</h2>
                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="UserID" value="{{ Auth::user()->UserID }}">
                        <input type="hidden" name="BukuID" value="{{ $item->BukuID }}">

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Rating</label>
                            <div class="flex items-center space-x-1 mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label for="star-{{ $i }}" class="cursor-pointer">
                                        <input type="radio" name="Rating" id="star-{{ $i }}"
                                            value="{{ $i }}" class="hidden star-input" required>
                                        <svg class="w-8 h-8 star-svg {{ $i <= old('Rating', 0) ? 'text-zinc-700' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            @error('Rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="Ulasan" class="block text-gray-700 font-bold mb-2">Ulasan</label>
                            <textarea name="Ulasan" id="Ulasan" rows="4"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-zinc-700"
                                placeholder="Tulis ulasan Anda tentang buku ini" required></textarea>
                            @error('Ulasan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-zinc-700 text-white py-2 rounded-lg hover:bg-black transition duration-300">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            @else
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow-lg sticky top-4">
                        <h2 class="text-2xl font-bold mb-6">Pinjam Buku Ini</h2>
                        @if ($Fadly_buku->first()->peminjaman()->whereIn('StatusPeminjaman', ['Dipinjam', 'Tertunda'])->count() > 0)
                            @php
                                $Fadly_isDipinjamOlehUser =
                                    $Fadly_buku
                                        ->first()
                                        ->peminjaman()
                                        ->where('StatusPeminjaman', 'Dipinjam')
                                        ->where('UserID', auth()->id())
                                        ->count() > 0;
                                $Fadly_hitungPeminjaman = Auth::user()
                                    ? Auth::user()->peminjaman()->where('StatusPeminjaman', 'Dipinjam')->count()
                                    : 0;
                            @endphp



                            @if ($Fadly_hitungPeminjaman < 3)
                                @if ($Fadly_isDipinjamOlehUser)
                                    <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
                                        <p> Anda sedang meminjam buku ini. Harap kembalikan sebelum
                                            <strong>{{ $Fadly_buku->first()->peminjaman()->where('StatusPeminjaman', 'Dipinjam')->first()->TanggalPengembalian }}</strong>.
                                        </p>
                                    </div>
                                @else
                                    @if (auth()->user()->isAdmin())
                                        <p class="text-red-500 mt-4">Admin tidak diperbolehkan meminjam buku.</p>
                                    @else
                                        <p class="text-red-500 mt-4"> Buku ini sedang dipinjam oleh pengguna lain dan
                                            tidak
                                            tersedia saat ini.</p>
                                    @endif
                                @endif
                            @else
                                <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
                                    <p> Anda sudah mencapai batas peminjaman. Harap kembalikan
                                        <strong>{{ $Fadly_hitungPeminjaman }}</strong>
                                        buku tepat waktu.
                                    </p>
                                </div>
                            @endif
                        @else
                            <form action="{{ route('peminjaman.user.store') }}" method="POST">
                                @csrf
                                @if (Auth::check())
                                    <input type="hidden" name="UserID" value="{{ Auth::user()->UserID }}">
                                @else
                                    <p>Anda harus login terlebih dahulu.</p>
                                @endif

                                <input type="hidden" name="BukuID" value="{{ $Fadly_buku->first()->BukuID }}">

                                <div class="space-y-6">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <label for="Fadly_TanggalPeminjaman"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Tanggal Peminjaman
                                            </label>
                                            <input type="date" name="Fadly_TanggalPeminjaman"
                                                id="Fadly_TanggalPeminjaman" min="{{ date('Y-m-d') }}"
                                                value="{{ now()->toDateString() }}"
                                                class="w-full px-4 py-2 border rounded-lg" required>
                                        </div>
                                        <div>
                                            <label for="Fadly_TanggalPengembalian"
                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                Tanggal Pengembalian
                                            </label>
                                            <input type="date" name="Fadly_TanggalPengembalian"
                                                id="Fadly_TanggalPengembalian"
                                                min="{{ now()->addDay()->toDateString() }}"
                                                max="{{ now()->addDays(14)->toDateString() }}"
                                                class="w-full px-4 py-2 border rounded-lg" required>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="w-full px-6 py-3 text-white bg-zinc-700 rounded hover:bg-black">
                                        Pinjam Buku
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
