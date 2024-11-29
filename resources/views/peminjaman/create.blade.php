<x-dashboard-layout>

    <h1 class="mb-6 text-3xl font-bold">Buat Peminjaman</h1>

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf

        <input type="hidden" name="BukuID" value="{{ $buku->BukuID }}">
        <div class="space-y-6">
            <div>
                <label for="UserID" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih User
                </label>
                @if ($users->isEmpty())
                    <p>Tidak ada user yang tersedia</p>
                @else
                    <select name="UserID" id="UserID" class="w-full px-4 py-2 border rounded-lg" required>
                        <option value="">Pilih User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->UserID }}" {{ $user->peminjaman_count >= 3 ? 'disabled' : '' }}>
                                {{ $user->Username }}
                                @if ($user->peminjaman_count >= 3)
                                    (Tidak Tersedia - Telah Meminjam Buku)
                                @endif
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">


                {{-- <div>
                    <label for="Fadly_TanggalPeminjaman" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Peminjaman
                    </label>
                    <input type="date" name="Fadly_TanggalPeminjaman" id="Fadly_TanggalPeminjaman"
                        min="{{ date('Y-m-d') }}" value="{{ now()->toDateString() }}"
                        class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label for="Fadly_TanggalPengembalian" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Pengembalian
                    </label>
                    <input type="date" name="Fadly_TanggalPengembalian" id="Fadly_TanggalPengembalian"
                        min="{{ now()->addDay()->toDateString() }}" max="{{ now()->addDays(14)->toDateString() }}"
                        class="w-full px-4 py-2 border rounded-lg" required>
                </div> --}}
                <div>
                    <label for="Fadly_TanggalPeminjaman" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Peminjaman
                    </label>
                    <input type="date" name="Fadly_TanggalPeminjaman" id="Fadly_TanggalPeminjaman"
                        class="w-full px-4 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label for="Fadly_TanggalPengembalian" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Pengembalian
                    </label>
                    <input type="date" name="Fadly_TanggalPengembalian" id="Fadly_TanggalPengembalian"
                        class="w-full px-4 py-2 border rounded-lg" required>
                </div>
            </div>
            <button type="submit" class="w-full px-6 py-3 text-white bg-zinc-700 rounded hover:bg-black">
                Pinjam Buku
            </button>
        </div>
    </form>
</x-dashboard-layout>
