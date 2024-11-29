<x-dashboard-layout>

    <div class="container mx-auto max-w-7xl px-4 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-2xl font-semibold"> Daftar Peminjaman Buku </h2>
                <p class="text-sm mt-1"> Menampilkan {{ $Fadly_peminjaman->count() }} Peminjaman </p>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative w-full sm:w-64"> <input type="text" id="searchInput" name="search"
                        placeholder="Cari peminjaman..."
                        class="w-full px-4 py-2 pl-10 border rounded-lg focus:outline-none focus:ring-1 focus:ring-black" />
                    <svg class="absolute w-5 h-5 left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"> </path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($Fadly_peminjaman as $Fadly_value)
                <div
                    class="activity-card border rounded-lg shadow-sm transition-all duration-200 hover:shadow-md
                    @if ($Fadly_value->TanggalPengembalian < now() && !in_array($Fadly_value->StatusPeminjaman, ['Dikembalikan', 'Diulas'])) border-red-500 @endif
                    bg-white">
                    <div class="p-4 border-b">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3"> <span
                                    class="text-sm font-extrabold">{{ $loop->iteration }}</span> <span
                                    class="font-medium text-sm text-slate-600">
                                    {{ $Fadly_value->user->Username ?? 'User Dihapus' }} </span> </div>
                            <div class="flex flex-col items-end space-y-1"> <span
                                    class="px-2 py-1 text-xs border rounded-md"> {{ $Fadly_value->StatusPeminjaman }}
                                </span> <span class="text-xs text-slate-500">
                                    {{ $Fadly_value->created_at?->format('d M Y, H:i') ?? '-' }} </span> </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="activity-details mt-4 space-y-3"> <x-detail-row label="No Peminjaman | Buku"
                                value="{{ $Fadly_value->PeminjamanID }} | {{ $Fadly_value->BukuID }}" /> <x-detail-row
                                label="User" value="{{ $Fadly_value->user->Username ?? '-' }}" /> <x-detail-row
                                label="Peminjaman"
                                value="{{ \Carbon\Carbon::parse($Fadly_value->TanggalPeminjaman)->diffForHumans() }}" />
                            <x-detail-row label="Pengembalian"
                                value="{{ \Carbon\Carbon::parse($Fadly_value->TanggalPengembalian)->diffForHumans() }}" />
                            <x-detail-row label="Buku" value="{{ Str::limit($Fadly_value->buku->Judul, 20) }}" />
                            @if (!empty($Fadly_value->buku->image))
                                <div class="flex items-center justify-between pb-2"> <span
                                        class="text-sm font-medium min-w-[120px]">Image</span> <img
                                        src="{{ asset('images/' . $Fadly_value->buku->image) }}" alt="Book Image"
                                        class="w-16 h-16 object-cover rounded"> </div>
                            @endif
                            <div class="flex flex-col justify-between sm:flex-row sm:items-center pb-2">
                                <div class="text-xs font-medium min-w-[120px] flex space-x-3">
                                    @if ($Fadly_value->StatusPeminjaman === 'Tertunda')
                                        <form action="{{ route('peminjaman.destroy', $Fadly_value->PeminjamanID) }}"
                                            method="POST" class="inline"> @csrf @method('DELETE') <button
                                                type="submit"
                                                class="font-medium text-black underline hover:no-underline">
                                                Tolak </button> </form>
                                    @elseif ($Fadly_value->StatusPeminjaman === 'Ditolak')
                                        <span>Ditolak</span>
                                    @elseif ($Fadly_value->StatusPeminjaman === 'Dikembalikan')
                                        <span>Dikembalikan</span>
                                    @elseif ($Fadly_value->StatusPeminjaman === 'Diulas')
                                        <span>Diulas</span>
                                    @else
                                        <x-dropdown align="right" width="48"> <x-slot name="trigger"> <button
                                                    class="flex items-center"> <span
                                                        class="text-xs underline hover:no-underline">Denda</span>
                                                </button> </x-slot> <x-slot name="content">
                                                <form
                                                    action="{{ route('peminjaman.create_denda', $Fadly_value->PeminjamanID) }}"
                                                    method="POST" class="inline"> @csrf
                                                    <div class="space-y-2 p-2" onclick="event.stopPropagation()">
                                                        <div class="flex items-center"> <input type="checkbox"
                                                                name="jenis_denda[]" value="kerusakan_ringan"
                                                                class="mr-2 accent-zinc-900"> <label
                                                                for="kerusakan_ringan" class="text-xs">Kerusakan
                                                                Ringan</label> </div>
                                                        <div class="flex items-center"> <input type="checkbox"
                                                                name="jenis_denda[]" value="kerusakan_berat"
                                                                class="mr-2 accent-zinc-900"> <label
                                                                for="kerusakan_berat" class="text-xs">Kerusakan
                                                                Berat</label> </div>
                                                    </div>
                                                    <button type="submit" class="text-sm py-1 px-2 hover:underline">
                                                        Buat Denda
                                                    </button>
                                                </form>
                                            </x-slot> </x-dropdown>
                                    @endif
                                    @if (!in_array($Fadly_value->StatusPeminjaman, ['Dikembalikan', 'Tertunda', 'Ditolak', 'Diulas']))
                                        <form method="POST"
                                            action="{{ route('peminjaman.update', $Fadly_value->PeminjamanID) }}">
                                            @csrf <button type="submit"
                                                class="font-medium text-black underline hover:no-underline">
                                                Kembalikan </button> </form>
                                    @endif
                                </div>
                                <div class="text-sm mt-1 sm:mt-0">
                                    @if ($Fadly_value->StatusPeminjaman === 'Tertunda')
                                        <form method="POST"
                                            action="{{ route('peminjaman.verify', $Fadly_value->PeminjamanID) }}">
                                            @csrf <button type="submit" class="underline text-sm"> Verifikasi
                                            </button> </form>
                                    @elseif (!in_array($Fadly_value->StatusPeminjaman, ['Ditolak', 'Tertunda']))
                                        <span>Terverifikasi</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-dashboard-layout>
