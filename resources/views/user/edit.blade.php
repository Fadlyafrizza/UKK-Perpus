<x-dashboard-layout>
    <h1 class="mb-6 text-3xl font-bold">Edit User</h1>

    <form action="{{ route('user.update', $user->UserID) }}" method="POST" class="p-6 bg-white rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="Username" class="block mb-2 font-bold text-gray-700">Username</label>
            <input type="text" name="Username" id="Username" value="{{ old('Username', $user->Username) }}"
                class="w-full px-3 py-2 border rounded-lg @error('Username') border-red-500 @enderror" required>
            @error('Username')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="NamaLengkap" class="block mb-2 font-bold text-gray-700">Nama Lengkap</label>
            <input type="text" name="NamaLengkap" id="NamaLengkap"
                value="{{ old('NamaLengkap', $user->NamaLengkap) }}"
                class="w-full px-3 py-2 border rounded-lg @error('NamaLengkap') border-red-500 @enderror" required>
            @error('NamaLengkap')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="Email" class="block mb-2 font-bold text-gray-700">Email</label>
            <input type="email" name="Email" id="Email" value="{{ old('Email', $user->Email) }}"
                class="w-full px-3 py-2 border rounded-lg @error('Email') border-red-500 @enderror">
            @error('Email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="Password" class="block mb-2 font-bold text-gray-700">Password</label>
            <input type="password" name="Password" id="Password"
                class="w-full px-3 py-2 border rounded-lg @error('Password') border-red-500 @enderror">
            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
            @error('Password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="Password_confirmation" class="block mb-2 font-bold text-gray-700">Konfirmasi Password</label>
            <input type="password" name="Password_confirmation" id="Password_confirmation"
                class="w-full px-3 py-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label for="Alamat" class="block mb-2 font-bold text-gray-700">Alamat</label>
            <textarea name="Alamat" id="Alamat" rows="3"
                class="block w-full px-3 py-2 mt-1 border rounded-lg @error('Alamat') border-red-500 @enderror">{{ old('Alamat', $user->Alamat) }}</textarea>
            @error('Alamat')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="roles" class="block mb-2 font-bold text-gray-700">Role</label>
            <select name="roles"
                class="w-full p-2 border rounded-md shadow-sm @error('roles') border-red-500 @enderror">
                <option value="">Pilih Role</option>
                @foreach (\App\Enums\RolesUser::cases() as $Fadly_role)
                    <option value="{{ $Fadly_role->value }}"
                        {{ old('roles', $user->roles) == $Fadly_role->value ? 'selected' : '' }}>
                        {{ ucfirst($Fadly_role->value) }}
                    </option>
                @endforeach
            </select>
            @error('roles')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('user.index') }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 text-white bg-zinc-700 rounded hover:bg-black">
                Update User
            </button>
        </div>
    </form>
</x-dashboard-layout>
