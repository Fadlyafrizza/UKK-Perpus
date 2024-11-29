<x-dashboard-layout>
    <h1 class="mb-6 text-3xl font-bold">Tambah Buku</h1>

    <form action="{{ route('buku.store') }}" method="POST" class="p-6 bg-white rounded-lg shadow-md"
        enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="Judul" class="block mb-2 font-bold text-gray-700">Judul</label>
            <input type="text" name="Judul" id="Judul" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="Penulis" class="block mb-2 font-bold text-gray-700">Penulis</label>
            <input type="text" name="Penulis" id="Penulis" class="w-full px-3 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="Penerbit" class="block mb-2 font-bold text-gray-700">Penerbit</label>
            <input type="text" name="Penerbit" id="Penerbit" class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="TahunTerbit" class="block mb-2 font-bold text-gray-700">Tahun Terbit</label>
            <select name="TahunTerbit" id="TahunTerbit" class="w-full px-3 py-2 border rounded-lg" required>
                <option value="" disabled selected>Pilih Tahun Terbit</option>
                @foreach (range(date('Y'), 1900) as $year)
                    <option value="{{ $year }}" {{ old('TahunTerbit') == $year ? 'selected' : '' }}>
                        {{ $year }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label for="image" class="block mb-2 font-bold text-gray-700">Tahun Terbit</label>
            <input type="file" name="image" id="image" class="w-full px-3 py-2 border rounded-lg">
        </div>
        <div class="mb-4">
            <label class="block mb-2 font-bold text-gray-700">Kategori</label>
            @foreach ($kategori as $value)
                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" name="kategori[]" value="{{ $value->KategoriID }}" class="form-checkbox">
                    <span class="ml-2">{{ $value->NamaKategori }}</span>
                </label>
            @endforeach
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 text-white bg-zinc-700 rounded hover:bg-black">Tambah
                Buku
            </button>
        </div>
    </form>
</x-dashboard-layout>
