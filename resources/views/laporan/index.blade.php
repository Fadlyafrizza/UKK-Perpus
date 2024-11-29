<x-dashboard-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-extrabold mb-6 text-gray-800">
            StudyStacks Laporan
        </h1>
        <p class="text-gray-600 mb-8">
            Pilih Laporan untuk melihat laporan dan mendownload detail laporan.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <x-laporan-link href="{{ route('laporan.books') }}">
                <span class="text-lg font-semibold">Laporan Buku</span>
            </x-laporan-link>

            <x-laporan-link href="{{ route('laporan.denda') }}">
                <span class="text-lg font-semibold">Laporan Peminjaman</span>
            </x-laporan-link>

            <x-laporan-link href="{{ route('laporan.fines') }}">
                <span class="text-lg font-semibold">Laporan Denda</span>
            </x-laporan-link>

        </div>
    </div>
</x-dashboard-layout>
