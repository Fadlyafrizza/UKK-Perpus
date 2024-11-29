<x-app-layout>
    <div class="container px-4 mx-auto py-[8rem]">
        <div class="max-w-xl p-6 mx-auto border border-black rounded-lg shadow-md">
            <h2 class="mb-6 text-2xl font-bold text-center">Register</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid grid-cols-2 gap-2 bg-transparent">
                    <div class="mb-4">
                        <label for="username" class="block mb-2 text-sm font-bold text-gray-700">Username</label>
                        <input type="text" name="username" id="username"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border bg-transparent rounded border-black appearance-none focus:outline-none focus:shadow-outline"
                            required>
                        @error('username')
                            <p class="text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="NamaLengkap" class="block mb-2 text-sm font-bold text-gray-700">Nama
                            Lengkap</label>
                        <input type="text" name="NamaLengkap" id="NamaLengkap"
                            class="w-full px-3 py-2 leading-tight text-gray-700 border bg-transparent rounded border-black appearance-none focus:outline-none focus:shadow-outline"
                            required>
                        @error('NamaLengkap')
                            <p class="text-xs italic text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block mb-2 text-sm font-bold text-gray-700">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border bg-transparent rounded border-black appearance-none focus:outline-none focus:shadow-outline"
                        required>
                    @error('email')
                        <p class="text-xs italic text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="Alamat" class="block mb-2 text-sm font-bold text-gray-700">Alamat</label>
                    <input type="text" name="Alamat" id="Alamat"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border bg-transparent rounded border-black appearance-none focus:outline-none focus:shadow-outline"
                        required>
                    @error('Alamat')
                        <p class="text-xs italic text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-bold text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border bg-transparent rounded border-black appearance-none focus:outline-none focus:shadow-outline"
                        required>
                    @error('password')
                        <p class="text-xs italic text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block mb-2 text-sm font-bold text-gray-700">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-3 py-2 leading-tight text-gray-700 border bg-transparent rounded border-black appearance-none focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="px-4 py-2 font-bold text-white bg-zinc-700 hover:bg-black rounded-md">
                        Register
                    </button>
                    <a href="{{ route('login') }}"
                        class="inline-block text-sm font-bold underline align-baseline hover:no-underline">
                        Sudah punya akun?
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
