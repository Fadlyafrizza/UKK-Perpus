<x-dashboard-layout>


    <div class="container py-8 mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class=" text-2xl font-bold">Daftar Kategori</h2>

            <a href="{{ route('kategori.create') }}"
                class="inline-flex px-4 py-2 font-bold border border-black rounded-lg text-zinc-500 hover:text-black">
                <svg class="w-5 h-5 mt-px mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </a>
        </div>
        <div class="relative overflow-x-auto border shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                Kategori
                                <a href="#" class="sort" data-sort="kategori">
                                    <svg class="w-3 h-3 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                    </svg>
                                </a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach ($kategori as $Fadly_value)
                        <tr class="bg-white border-b dark:bg-gray-800 ">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $Fadly_value->NamaKategori }}
                            </td>
                            <td class="px-6 py-4">
                                {!! Str::limit($Fadly_value->deskripsi, 25) !!}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('kategori.edit', $Fadly_value) }}"
                                    class="mr-3 font-medium hover:underline">Edit</a>
                                <form action="{{ route('kategori.destroy', $Fadly_value) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-black text-bold hover:underline"
                                        onclick="return confirm('Apakah kamu serius ingin menghapus Kategori ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</x-dashboard-layout>
