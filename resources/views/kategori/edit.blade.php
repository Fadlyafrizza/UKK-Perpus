<x-dashboard-layout>
    <h1 class="mb-6 text-3xl font-bold">Edit Kategori</h1>

    <form action="{{ route('kategori.update', $kategori->KategoriID) }}" method="POST"
        class="p-6 bg-white rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="NamaKategori" class="block mb-2 font-bold text-gray-700">Nama Kategori</label>
            <input type="text" name="NamaKategori" id="NamaKategori" class="w-full px-3 py-2 border rounded-lg"
                value="{{ old('NamaKategori', $kategori->NamaKategori) }}" required>
        </div>



        <div class="mb-4">
            <label for="deskripsi" class="block mb-2 font-bold text-gray-700">Deskripsi</label>
            <textarea id="description" rows="3" name="deskripsi" id="deskripsi"
                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-lg focus:ring-opacity-50">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 text-white bg-zinc-700 rounded hover:bg-black">Edit
                Kategori</button>
        </div>
    </form>
</x-dashboard-layout>
